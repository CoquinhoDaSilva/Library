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
     * @param Request $request
     * @return Response
     */

    public function insertBook(EntityManagerInterface $entityManager, Request $request) {

        $book = new Book();

        $title = $request->query->get('title');
        $resume = $request->query->get('resume');
        $author = $request->query->get('author');
        $nbPages = $request->query->get('nbPages');

        $book->setTitle($title);
        $book->setResume($resume);
        $book->setAuthor($author);
        $book->setNbPages($nbPages);

        $entityManager->persist($book);
        $entityManager->flush();

        return new Response('Livre enregistré');
    }


    /**
     * @Route("/books/delete/{id}", name="delete_book")
     * @param BookRepository $bookRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return Response
     */
    public function deleteBook(BookRepository $bookRepository, EntityManagerInterface $entityManager, $id) {

        $book = $bookRepository->find($id);

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('books');
    }

    /**
     * @Route("/books/update/{id}", name="update_book")
     * @param BookRepository $bookRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return Response
     */
    public function updateBook(BookRepository $bookRepository, EntityManagerInterface $entityManager, $id) {

        $book = $bookRepository->find($id);

        $book->setTitle('blubaliblu');

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('books');


    }

}