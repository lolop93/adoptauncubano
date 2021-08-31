<?php

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MensajesController extends AbstractController
{
    /**
     * @Route("/mensajes", name="mensajes", options={"expose"=true})
     */
    public function index(Request $request): Response
    {
        if($request->isXMLHttpRequest()){
            $user = $this->getUser();
            $id = $user->getId();
            return new JsonResponse(['id'=>$id]);


        }else{
            return $this->render('mensajes/index.html.twig', [
                'controller_name' => 'MensajesController',
            ]);
            //throw new Exception("Holi :)");
        }


    }
}
