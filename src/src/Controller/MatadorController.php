<?php

namespace App\Controller;

use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatadorController extends AbstractController
{
    #[Route('/matador', name: 'matador')]
    public function index(MobileDetector $pantalla): Response
    {
        $login = $this->get('security.token_storage')->getToken()->getUser();

        if($pantalla->isMobile() && !$pantalla->isTablet()){
            return $this->render('matador/matadorMobile.html.twig', [
                'login' => $login,
            ]);
        }else {
            return $this->render('matador/matador.html.twig', [
                'login' => $login,
            ]);
        }
    }
}
