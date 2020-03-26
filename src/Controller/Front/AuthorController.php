<?php

namespace App\Controller\Front;


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

        return $this->render('Front/Authors/authors.html.twig', [
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

        return $this->render('Front/Authors/author.html.twig', [
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

        return $this->render('Front/Authors/authorsearch.html.twig', [
            'search'=>$search,
            'authors'=>$authors
        ]);
    }


}