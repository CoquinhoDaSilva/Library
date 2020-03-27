<?php

namespace App\Controller\Front;


use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    /**
     * @Route("/", name="home")
     * @param AuthorController $authorController
     * @param BookController $bookController
     * @return Response
     */
    public function HomeController(BookRepository $bookRepository, AuthorRepository $authorRepository) {

        /* METHODE 1
        $books = $bookRepository->findAll();
        $lastBooks = array_slice($books, -2, 2);

        $authors = $authorRepository->findAll();
        $lastAuthors = array_slice($authors, -2, 2);
        */

        $lastBooks = $bookRepository->findBy([], ['id'=>'DESC'], 2, 0);
        $lastAuthors = $authorRepository->findBy([], ['id'=>'DESC'], 2, 0);

        return $this->render('Front/Home/home.html.twig', [
            'lastauthors'=>$lastAuthors,
            'lastbooks'=>$lastBooks
        ]);
    }
}