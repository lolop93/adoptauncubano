<?php

namespace App\Controller;

use App\Repository\GaleriaRepository;
use App\Repository\UserAttributesRepository;
use App\Repository\UserRepository;
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
    public function perfil(UserRepository $userRepository, GaleriaRepository $galeriaRepository, UserAttributesRepository $userAttributesRepository): Response
    {
        $login = $this->get('security.token_storage')->getToken()->getUser();


        $galeriaRepository->findAll();

        $userAttributesRepository->findAll();

        return $this->render('mi_cuenta/perfil.html.twig', [
            'login' => $login,
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
