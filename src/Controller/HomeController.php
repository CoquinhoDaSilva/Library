<?php

namespace App\Controller;


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
    public function HomeController() {

        return $this->render('home.html.twig');
    }
}