<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VueController extends AbstractController
{
    #[Route('/{path}', requirements: ['path' => '.+'],  defaults: ['path' => null], methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }
}
