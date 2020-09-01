<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatementController extends AbstractController
{
    /**
     * @Route("/enonce",
     *     name="_statement",
     *     options={"expose": true},
     *     methods={"GET"})
     * @return Response
     */
    public function index():Response{
        return $this->render('statement/statement-index.html.twig', []);
    }
}