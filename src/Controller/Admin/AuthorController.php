<?php

namespace App\Controller\Admin;


use App\Entity\Author;
use App\Form\AuthorType;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorController extends AbstractController {

    /**
     * @Route("/admin/authors", name="admin_authors")
     * @param AuthorRepository $bookrepository
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function authors(AuthorRepository $bookrepository) {

        $authors = $bookrepository->findAll();

        return $this->render('Admin/Authors/authors.html.twig', [
            'authors' => $authors
        ]);
    }

    /**
     * @Route("/admin/authors/show/{id}", name="admin_author")
     * @param AuthorRepository $authorRepository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function author(AuthorRepository $authorRepository, $id) {

        $author = $authorRepository->find($id);

        return $this->render('Admin/Authors/author.html.twig', [
            'author' => $author
        ]);
    }

    /**
     * @Route("/admin/authors/search", name="admin_author_search")
     * @param AuthorRepository $authorRepository
     * @param Request $request
     * @return Response
     */
    public function authorsearch(AuthorRepository $authorRepository, Request $request) {

        $search = $request->query->get('search');
        $authors = $authorRepository->getByWordInName($search);

        return $this->render('Admin/Authors/authorsearch.html.twig', [
            'search'=>$search,
            'authors'=>$authors
        ]);
    }

    /**
     * @Route("/admin/authors/delete/{id}", name="admin_authors_delete")
     * @param AuthorRepository $authorRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return RedirectResponse
     */
    public function authorsDelete(AuthorRepository $authorRepository, EntityManagerInterface $entityManager, $id) {

        $author = $authorRepository->find($id);

        $entityManager->remove($author);
        $entityManager->flush();

        $this->addFlash('success', 'L\'auteur a bien été supprimé !');


        return $this->redirectToRoute('admin_authors');
    }

    /**
     * @Route("/admin/authors/insert", name="admin_authors_insert")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function authorsInsert(EntityManagerInterface $entityManager, Request $request) {

        $author = new Author;

        $formAuthor = $this->createForm(AuthorType::class, $author);
        $formAuthor->handleRequest($request);

        if ($formAuthor->isSubmitted() && $formAuthor->isValid()) {

            $entityManager->persist($author);
            $entityManager->flush();

            $this->addFlash('success', 'L\'auteur a bien été ajouté !');

        }

        return $this->render('Admin/Authors/insert.html.twig', [
            'formAuthor'=>$formAuthor->createView()
        ]);
    }


    /**
     * @Route("/admin/authors/update/{id}", name="admin_authors_update")
     * @param Request $request
     * @param AuthorRepository $authorRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return RedirectResponse
     */
    public function authorsUpdate(Request $request, AuthorRepository $authorRepository, EntityManagerInterface $entityManager, $id) {

        $author = $authorRepository->find($id);

        $formAuthor = $this->createForm(AuthorType::class, $author);
        $formAuthor->handleRequest($request);

        if ($formAuthor->isSubmitted() && $formAuthor->isValid()) {

            $entityManager->persist($author);
            $entityManager->flush();

            $this->addFlash('success', 'L\'auteur a bien été modifié !');

        }

        return $this->render('Admin/Authors/update.html.twig', [
            'formAuthor'=> $formAuthor->createView()
        ]);


    }
}