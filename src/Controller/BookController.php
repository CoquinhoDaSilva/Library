<?php


namespace App\Controller;


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
     * @Route("/books/show/{id}", name="book")
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

    /**
     * @Route("/books/insert", name="book_insert")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */

    public function insertBook(EntityManagerInterface $entityManager) {

        $book = new Book();

        $book->setTitle('Titre');
        $book->setResume('Resume');
        $book->setAuthor('Author');
        $book->setNbPages(3);

        $entityManager->persist($book);
        $entityManager->flush();

        return new Response('Livre enregistré');
    }

}