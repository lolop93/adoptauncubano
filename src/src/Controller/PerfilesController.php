<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PerfilesController extends AbstractController
{
    #[Route('/perfiles/{id}', name: 'perfiles')]
    public function index(UserRepository $userRepository, int $id): Response
    {
        $login = $this->get('security.token_storage')->getToken()->getUser();

        $user = $userRepository->findOneBy(
            ['id' => $id],
        );

        return $this->render('perfiles/index.html.twig', [
            'id' => $id,
            'login' => $login,
            'user' => $user,
        ]);
    }

}
