<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\LikesRepository;
use App\Repository\UserRepository;
use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PerfilesController extends AbstractController
{
    #[Route('/perfiles/{id}', name: 'perfiles')]
    public function index(MobileDetector $pantalla, UserRepository $userRepository, int $id, LikesRepository $likesRepository): Response
    {
        $login = $this->get('security.token_storage')->getToken()->getUser();
        $users = $userRepository->findAll();
        $likes = $likesRepository->findAll();
        $likesRecibidos = $login->getLikesRecibidos();
        $likesDados = $login->getLikesDados();
        $login = $this->get('security.token_storage')->getToken()->getUser();

        $user = $userRepository->findOneBy(
            ['id' => $id],
        );




        if($likesDados->count() > 0){//comprobamos que ha dado me gusta a alguien al menos
            foreach ($likesDados as $likesDado){
                $likesTotales[]= $likesDado->getLikesTo()->getId(); //los Likes dados son likes en los que $likesTo es el otro usuario
            }
        }else{//Si tampoco le ha dado me gusta a nadie
            $likesTotales = array(); //creamos un array vacio
        }


        if($pantalla->isMobile() && !$pantalla->isTablet()){
            return $this->render('perfiles/indexMobile.html.twig', [
                'id' => $id,
                'login' => $login,
                'user' => $user,

                'likesTotales' => $likesTotales,
            ]);
        }else {
            return $this->render('perfiles/index.html.twig', [
                'id' => $id,
                'login' => $login,
                'user' => $user,

                'likesTotales' => $likesTotales,
            ]);
        }
    }

}
