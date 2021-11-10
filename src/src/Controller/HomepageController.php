<?php

namespace App\Controller;

use App\Repository\ConversacionesRepository;
use App\Repository\GaleriaRepository;
use App\Repository\LikesRepository;
use App\Repository\MensajesRepository;
use App\Repository\UserAttributesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;

class HomepageController extends AbstractController
{
    #[Route('/homepage', name: 'homepage')]
    public function perfil(MobileDetector $pantalla, UserRepository $userRepository, GaleriaRepository $galeriaRepository, UserAttributesRepository $userAttributesRepository,ConversacionesRepository $conversacionesRepository,MensajesRepository $mensajesRepository,LikesRepository $likesRepository): Response
    {

        $login = $this->get('security.token_storage')->getToken()->getUser();
        $users = $userRepository->findAll();
        $likes = $likesRepository->findAll();
        $likesRecibidos = $login->getLikesRecibidos();
        $likesDados = $login->getLikesDados();
        $mensajes = $mensajesRepository->findAll();
        $conversaciones = $conversacionesRepository->findAll();
        $galerias = $galeriaRepository->findAll();
        $atributos = $userAttributesRepository->findAll();
        $mensajeslogin =  $login->getMensajes();

        if($likesDados->count() > 0){//comprobamos que ha dado me gusta a alguien al menos
            foreach ($likesDados as $likesDado){
                $likesTotales[]= $likesDado->getLikesTo()->getId(); //los Likes dados son likes en los que $likesTo es el otro usuario
            }
        }else{//Si tampoco le ha dado me gusta a nadie
            $likesTotales = array(); //creamos un array vacio
        }



        if($pantalla->isMobile() && !$pantalla->isTablet()){
            return $this->render('homepage/indexMobile.html.twig', [
                'users' => $users,
                'galerias' => $galerias,
                'atributos' => $atributos,
                'login' => $login,
                'likesTotales' => $likesTotales,
            ]);
        }else {
            return $this->render('homepage/index.html.twig', [
                'users' => $users,
                'galerias' => $galerias,
                'atributos' => $atributos,
                'login' => $login,
                'likesTotales' => $likesTotales,
                'conversaciones' => $conversaciones,
                'mensajes' => $mensajeslogin,
                'todosmensajes' => $mensajes,
            ]);
        }

    }


}
