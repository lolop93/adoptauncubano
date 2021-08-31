<?php

namespace App\Controller;

use App\Repository\GaleriaRepository;
use App\Repository\UserAttributesRepository;
use App\Repository\UserRepository;
use Detection\MobileDetect;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//use SunCat\MobileDetectBundle\MobileDetectBundle;
use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;


class MiCuentaController extends AbstractController
{
    //#[Route('/cuenta', name: 'mi_cuenta')]
    public function index(): Response
    {
        return $this->render('mi_cuenta/index.html.twig', [
            'controller_name' => 'MiCuentaController',
        ]);
    }

    #[Route('/cuenta/perfil', name: 'perfil')]
    public function perfil(MobileDetector $pantalla, UserRepository $userRepository, GaleriaRepository $galeriaRepository, UserAttributesRepository $userAttributesRepository): Response
    {
        $login = $this->get('security.token_storage')->getToken()->getUser();
        $galeriaRepository->findAll();
        $userAttributesRepository->findAll();

        //$mobileDetector = $this->get('mobile_detect.mobile_detector');


        if($pantalla->isMobile() && !$pantalla->isTablet()){
            return $this->render('mi_cuenta/perfilMobile.html.twig', [
                'login' => $login,
            ]);
        }else {
            return $this->render('mi_cuenta/perfil.html.twig', [
                'login' => $login,
            ]);
        }


    }
    #[Route('/cuenta/perfil/{id}', name: 'visitar')]
    public function perfilVisita(){

    }

    #[Route('/cuenta/ajustes', name: 'ajustes')]
    public function ajustes(): Response
    {
        $login = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render('mi_cuenta/ajustes.html.twig', [
            'login' => $login,
        ]);
    }
}
