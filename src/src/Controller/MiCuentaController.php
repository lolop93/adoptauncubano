<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MiCuentaController extends AbstractController
{
    #[Route('/cuenta', name: 'mi_cuenta')]
    public function index(): Response
    {
        return $this->render('mi_cuenta/index.html.twig', [
            'controller_name' => 'MiCuentaController',
        ]);
    }

    #[Route('/cuenta/perfil', name: 'perfil')]
    public function perfil(): Response
    {
        return $this->render('mi_cuenta/perfil.html.twig', [
            'controller_name' => 'MiCuentaController',
        ]);
    }

    #[Route('/cuenta/ajustes', name: 'ajustes')]
    public function ajustes(): Response
    {
        return $this->render('mi_cuenta/ajustes.html.twig', [
            'controller_name' => 'MiCuentaController',
        ]);
    }
}
