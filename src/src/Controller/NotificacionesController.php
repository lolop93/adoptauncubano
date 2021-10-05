<?php

namespace App\Controller;

use App\Repository\ConversacionesRepository;
use App\Repository\GaleriaRepository;
use App\Repository\MensajesRepository;
use App\Repository\UserAttributesRepository;
use App\Repository\UserRepository;
use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificacionesController extends AbstractController

{
    #[Route('/notificaciones', name: 'notificaciones')]
    public function notificaciones(MobileDetector $pantalla, UserRepository $userRepository, GaleriaRepository $galeriaRepository, UserAttributesRepository $userAttributesRepository,ConversacionesRepository $conversacionesRepository,MensajesRepository $mensajesRepository): Response
    {

        $login = $this->get('security.token_storage')->getToken()->getUser();

        $users = $userRepository->findAll();
        $mensajes = $mensajesRepository->findAll();
        $conversaciones = $conversacionesRepository->findAll();

        $galerias = $galeriaRepository->findAll();
        $atributos = $userAttributesRepository->findAll();

        $mensajeslogin =  $login->getMensajes();

        if($pantalla->isMobile() && !$pantalla->isTablet()){
            return $this->render('notificaciones/indexMobile.html.twig', [
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
                'conversaciones' => $conversaciones,
                'mensajes' => $mensajeslogin,
                'todosmensajes' => $mensajes,
            ]);
        }

    }


}
