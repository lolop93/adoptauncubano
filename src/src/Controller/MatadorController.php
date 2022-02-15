<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatadorController extends AbstractController
{
    #[Route('/matador', name: 'matador')]
    public function index(MobileDetector $pantalla, UserRepository $userRepository): Response
    {
        $login = $this->get('security.token_storage')->getToken()->getUser();
        $likesRecibidos = $login->getLikesRecibidos();
        $users = $userRepository->findAll();
        $contadorLikesMatador = 0;
        $contadorLikesMatadora = 0;
        $matadora = new User();
        $matador = new User();

        foreach ($users as $user){
            if($user->getAtributos() && $user->getAtributos()->getSexo() ){
                if($user->getAtributos()->getSexo()=="chico"){
                    if($user->getLikesRecibidos()->count() > $contadorLikesMatador){
                        $matador = $user;
                    }
                }else{
                    if($user->getLikesRecibidos()->count() > $contadorLikesMatadora){
                        $matadora = $user;
                    }
                }
            }
        }

        if($pantalla->isMobile() && !$pantalla->isTablet()){
            return $this->render('matador/matadorMobile.html.twig', [
                'login' => $login,
                'matador' => $matador,
                'matadora' => $matadora,
            ]);
        }else {
            return $this->render('matador/matador.html.twig', [
                'login' => $login,
                'matador' => $matador,
                'matadora' => $matadora,
            ]);
        }
    }
}
