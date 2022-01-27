<?php

namespace App\Controller;

use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HoroscopoController extends AbstractController
{
    #[Route('/horoscopo', name: 'horoscopo')]
    public function index(MobileDetector $pantalla): Response
    {
        $login = $this->get('security.token_storage')->getToken()->getUser();

        if($pantalla->isMobile() && !$pantalla->isTablet()){
            return $this->render('horoscopo/horoscopoMobile.html.twig', [
                'login' => $login,
            ]);
        }else {
            return $this->render('horoscopo/horoscopo.html.twig', [
                'login' => $login,
            ]);
        }
    }
}
