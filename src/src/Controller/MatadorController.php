<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatadorController extends AbstractController
{
    #[Route('/matador', name: 'matador')]
    public function index(): Response
    {
        return $this->render('matador/index.html.twig', [
            'controller_name' => 'MatadorController',
        ]);
    }
}
