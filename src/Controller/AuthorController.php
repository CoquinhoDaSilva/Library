<?php

namespace App\Controller;


use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorController extends AbstractController {

    /**
     * @Route("/authors", name="authors")
     * @param AuthorRepository $bookrepository
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function authors(AuthorRepository $bookrepository) {

        $authors = $bookrepository->findAll();

        return $this->render('authors.html.twig', [
            'authors' => $authors
        ]);
    }

    /**
     * @Route("/authors/show/{id}", name="author")
     * @param AuthorRepository $authorRepository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function author(AuthorRepository $authorRepository, $id) {

        $author = $authorRepository->find($id);

        return $this->render('author.html.twig', [
            'author' => $author
        ]);
    }

    /**
     * @Route("/authors/search", name="author_search")
     * @param AuthorRepository $authorRepository
     * @param Request $request
     * @return Response
     */
    public function authorsearch(AuthorRepository $authorRepository, Request $request) {

        $search = $request->query->get('search');
        $authors = $authorRepository->getByWordInName($search);

        return $this->render('authorsearch.html.twig', [
            'search'=>$search,
            'authors'=>$authors
        ]);
    }

    /**
     * @Route("/authors/delete/{id}", name="authors_delete")
     * @param AuthorRepository $authorRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return RedirectResponse
     */
    public function authorsDelete(AuthorRepository $authorRepository, EntityManagerInterface $entityManager, $id) {

        $author = $authorRepository->find($id);

        $entityManager->remove($author);
        $entityManager->flush();

        return $this->redirectToRoute('authors');
    }

    /**
     * @Route("/authors/insert", name="authors_insert")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function authorsInsert(EntityManagerInterface $entityManager, Request $request) {

        $authors = new Author();

        $firstname = $request->query->get('firstname');
        $name = $request->query->get('name');
        $dateofbirth = $request->query->get('dateofbirth');
        $biography = $request->query->get('biography');

        $authors->setFirstname($firstname);
        $authors->setName($name);
        $authors->setDateofbirth(new \DateTime($dateofbirth));
        $authors->setBiography($biography);

        $entityManager->persist($authors);
        $entityManager->flush();

        return new Response('L\'auteur a été rajouté');
    }

    /**
     * @Route("/authors/update/{id}", name="authors_update")
     * @param AuthorRepository $authorRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return RedirectResponse
     */
    public function authorsUpdate(AuthorRepository $authorRepository, EntityManagerInterface $entityManager, $id) {

        $author = $authorRepository->find($id);

        $author->setName('Boloss');

        $entityManager->persist($author);
        $entityManager->flush();

        return $this->redirectToRoute('authors');


    }
}