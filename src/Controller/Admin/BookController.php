<?php


namespace App\Controller\Admin;


use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends AbstractController
{

    /**
     * @Route("/admin/books", name="admin_books")
     * @param BookRepository $bookRepository
     * @return Response
     */

    public function books(BookRepository $bookRepository) {

        $books = $bookRepository->findAll();

        return $this->render('Admin/Books/books.html.twig', [
            'books' => $books
        ]);
    }


    /**
     * @Route("/admin/books/show/{id}", name="admin_book")
     * @param BookRepository $bookRepository
     * @param $id
     * @return Response
     */

    public function book(BookRepository $bookRepository, $id) {

        $book = $bookRepository->find($id);

        return $this->render('Admin/Books/book.html.twig',
            ['book' => $book
            ]);

    }

    /**
     * @Route("/admin/books/insert", name="admin_book_insert")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param AuthorRepository $authorRepository
     * @return Response
     */

    public function insertBook(EntityManagerInterface $entityManager, Request $request, AuthorRepository $authorRepository) {

        $book = new Book();

        $title = $request->query->get('title');
        $resume = $request->query->get('resume');
        $nbPages = $request->query->get('nbPages');

        $author = $authorRepository->find(1);

        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setResume($resume);
        $book->setNbPages($nbPages);

        $entityManager->persist($book);
        $entityManager->flush();

        return new Response('Livre enregistré');
    }


    /**
     * @Route("/admin/books/delete/{id}", name="admin_delete_book")
     * @param BookRepository $bookRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return Response
     */
    public function deleteBook(BookRepository $bookRepository, EntityManagerInterface $entityManager, $id) {

        $book = $bookRepository->find($id);

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('admin_books');
    }

    /**
     * @Route("/admin/books/update/{id}", name="admin_update_book")
     * @param BookRepository $bookRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function updateBook(BookRepository $bookRepository, EntityManagerInterface $entityManager, $id) {

        $book = $bookRepository->find($id);

        $book->setTitle('Nina est la meilleure');

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('admin_books');


    }

    /**
     * @Route("/admin/books/search", name="admin_search_book")
     * @param BookRepository $bookRepository
     * @param Request $request
     */
    public function searchBook(BookRepository $bookRepository, Request $request) {

        $search = $request->query->get('search');

        $books = $bookRepository->getByWordInResume($search);

        return $this->render('Admin/Books/search.html.twig', [
            'books'=> $books,
            'search'=> $search
        ]);
    }
}