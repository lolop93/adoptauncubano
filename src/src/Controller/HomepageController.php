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

        /*
        //comprobamos que los likes que ha dado a un usuario sea reciproco
        if($likesRecibidos->count() > 0){//Si ha recibidos likes buscamos
            foreach ($likesRecibidos as $likeRecibido){

                if(array_search($likeRecibido->getId(), $likesDados)){
                    $likesTotales[]= $likeRecibido->getLikesFrom()->getId(); //los Likes recibidos son likes en los que $likesFrom es el otro usuario
                }

            }
        }*/
        //else{//sino le ha dado me gusta nadie, pues cogemos solo los likes dados

            if($likesDados->count() > 0){//comprobamos que ha dado me gusta a alguien al menos
                foreach ($likesDados as $likesDado){
                    $likesTotales[]= $likesDado->getLikesTo()->getId(); //los Likes dados son likes en los que $likesTo es el otro usuario
                }
            }else{//Si tampoco le ha dado me gusta a nadie
                $likesTotales = array(); //creamos un array vacio
            }

        //}


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
                'likesTotales' => $likesTotales,
                'conversaciones' => $conversaciones,
                'mensajes' => $mensajeslogin,
                'todosmensajes' => $mensajes,
            ]);
        }

    }


}
