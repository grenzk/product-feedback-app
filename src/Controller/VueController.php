<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VueController extends AbstractController
{
    #[Route('/', name: 'client_home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route('/{path}', name: 'client_route', requirements: ['path' => '.+'], methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }
}
