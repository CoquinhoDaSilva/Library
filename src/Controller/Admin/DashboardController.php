<?php

namespace App\Controller\Admin;

use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController {

    /**
     * @Route("/admin", name="admin_dashboard")
     * @param BookRepository $bookRepository
     * @param AuthorRepository $authorRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminDashboard(BookRepository $bookRepository, AuthorRepository $authorRepository) {

        $books = $bookRepository->findAll();
        $authors = $authorRepository->findAll();

        return $this->render('Admin/dashboard.html.twig', [
            'books'=>$books,
            'authors'=>$authors
            ]);
    }

}

