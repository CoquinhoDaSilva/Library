<?php


namespace App\Controller;


use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{

    /**
     * @Route("/books/", name="books")
     * @param BookRepository $bookRepository
     * @return Response
     */

    public function books(BookRepository $bookRepository) {

        $books = $bookRepository->findAll();

        return $this->render('books.html.twig', [
            'books' => $books
        ]);
    }


    /**
     * @Route("/books/{id}", name="book")
     * @param BookRepository $bookRepository
     * @param $id
     * @return Response
     */

    public function book(BookRepository $bookRepository, $id) {

        $book = $bookRepository->find($id);

        return $this->render('book.html.twig',
        ['book' => $book
        ]);

    }


}