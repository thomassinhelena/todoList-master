<?php


namespace App\Controller;


use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParameterController extends AbstractController
{
    private StatusRepository $statusRepository;

    public function __construct(StatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;

    }
    /**
     * @Route("/parametres",
     *     name="_parameters",
     *     options={"expose": true},
     *     methods={"GET"})
     * @return Response
     */
    public function index():Response{
        $status = $this->statusRepository->findAll();
        return $this->render('parameter/parameter-index.html.twig', ["status"=>$status]);
    }
}