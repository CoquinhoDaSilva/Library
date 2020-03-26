<?php


namespace App\Controller\Front;


use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends AbstractController
{

    /**
     * @Route("/books", name="books")
     * @param BookRepository $bookRepository
     * @return Response
     */

    public function books(BookRepository $bookRepository) {

        $books = $bookRepository->findAll();

        return $this->render('Front/Books/books.html.twig', [
            'books' => $books
        ]);
    }


    /**
     * @Route("/books/show/{id}", name="book")
     * @param BookRepository $bookRepository
     * @param $id
     * @return Response
     */

    public function book(BookRepository $bookRepository, $id) {

        $book = $bookRepository->find($id);

        return $this->render('Front/Books/book.html.twig',
            ['book' => $book
            ]);

    }


    /**
     * @Route("/books/search", name="search_book")
     * @param BookRepository $bookRepository
     * @param Request $request
     */
    public function searchBook(BookRepository $bookRepository, Request $request) {

        $search = $request->query->get('search');

        $books = $bookRepository->getByWordInResume($search);

        return $this->render('Front/Books/search.html.twig', [
            'books'=> $books,
            'search'=> $search
        ]);
    }
}