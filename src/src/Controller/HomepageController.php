<?php

namespace App\Controller;

use App\Repository\GaleriaRepository;
use App\Repository\UserAttributesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;

class HomepageController extends AbstractController
{
    #[Route('/homepage', name: 'homepage')]
    public function perfil(MobileDetector $pantalla, UserRepository $userRepository, GaleriaRepository $galeriaRepository, UserAttributesRepository $userAttributesRepository): Response
    {



        $users = $userRepository->findAll();

        $galerias = $galeriaRepository->findAll();

        $atributos = $userAttributesRepository->findAll();

        $login = $this->get('security.token_storage')->getToken()->getUser();

        if($pantalla->isMobile() && !$pantalla->isTablet()){
            return $this->render('homepage/indexMobile.html.twig', [
                'users' => $users,
                'galerias' => $galerias,
                'atributos' => $atributos,
                'login' => $login,
            ]);
        }else {
            return $this->render('homepage/index.html.twig', [
                'users' => $users,
                'galerias' => $galerias,
                'atributos' => $atributos,
                'login' => $login,
            ]);
        }

    }

    #[Route('/usuario/{id}', name: 'usuario')]
    public function showUser(User $user, GaleriaRepository $galeriaRepository, UserAttributesRepository $attributesRepository): Response
    {

    }
}
