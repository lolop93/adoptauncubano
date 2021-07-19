<?php

namespace App\Controller;

use App\Repository\GaleriaRepository;
use App\Repository\UserAttributesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/homepage', name: 'homepage')]
    public function index(UserRepository $userRepository, GaleriaRepository $galeriaRepository, UserAttributesRepository $userAttributesRepository): Response
    {

        $users = $userRepository->findAll();

        $galerias = $galeriaRepository->findAll();

        $atributos = $userAttributesRepository->findAll();



        return $this->render('homepage/index.html.twig', [
            'users' => $users,
            'galerias' => $galerias,
            'atributos' => $atributos,
        ]);
    }

    #[Route('/usuario/{id}', name: 'usuario')]
    public function showUser(User $user, GaleriaRepository $galeriaRepository, UserAttributesRepository $attributesRepository): Response
    {

    }
}
