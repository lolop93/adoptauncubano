<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PerfilesController extends AbstractController
{
    #[Route('/perfiles/{id}', name: 'perfiles')]
    public function index(MobileDetector $pantalla, UserRepository $userRepository, int $id): Response
    {
        $login = $this->get('security.token_storage')->getToken()->getUser();

        $user = $userRepository->findOneBy(
            ['id' => $id],
        );
        $age = new \DateTime();//Pasamos la fecha en la que nació a Edad normal
        $a = ($login->getAtributos() && $login->getAtributos()->getFechaNac() ? date_diff($age, $login->getAtributos()->getFechaNac()) : "");


        if($pantalla->isMobile() && !$pantalla->isTablet()){
            return $this->render('perfiles/indexMobile.html.twig', [
                'id' => $id,
                'login' => $login,
                'user' => $user,
                'edad' =>  $a,
            ]);
        }else {
            return $this->render('perfiles/index.html.twig', [
                'id' => $id,
                'login' => $login,
                'user' => $user,
                'edad' =>  $a,
            ]);
        }
    }

}
