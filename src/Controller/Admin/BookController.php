<?php


namespace App\Controller\Admin;


use App\Entity\Book;
use App\Form\BookType;
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
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */

    public function insertBook(Request $request, EntityManagerInterface $entityManager) {
        // Création d'un nouveau livre
        $book = new Book;
        //association du nouveau livre avec un formulaire créé dans BookType
        $formBook = $this->createForm(BookType::class, $book);
        //le handleRequest récupère les données POST et les donne au formulaire
        $formBook->handleRequest(($request));
        // Si formBook est submit ET valide alors on modifie la BDD et on confirme cette modification
        if ($formBook->isSubmitted() && $formBook->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();
        }

        return $this->render('Admin/Books/insert.html.twig',[
            'formBook'=>$formBook->createView()
        ]);
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
    public function updateBook(Request $request, BookRepository $bookRepository, EntityManagerInterface $entityManager, $id) {

        $book = $bookRepository->find($id);
        $formBook = $this->createForm(BookType::class, $book);
        $formBook->handleRequest($request);

        if ($formBook->isSubmitted() && $formBook->isValid()) {

            $entityManager->persist($book);
            $entityManager->flush();
        }


        return $this->render('Admin/Books/update.html.twig', [
            'formBook'=>$formBook->createView()
        ]);


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