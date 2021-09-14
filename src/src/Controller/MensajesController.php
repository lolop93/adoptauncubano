<?php

namespace App\Controller;



use App\Entity\Conversaciones;
use App\Repository\ConversacionesRepository;
use App\Repository\GaleriaRepository;
use App\Repository\MensajesRepository;
use App\Repository\UserAttributesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

//funcion para ordenar por fecha las conversaciones
function compararFecha($element1, $element2) {
    $datetime1 = strtotime($element1->getFecha());
    $datetime2 = strtotime($element2->getFecha());
    return $datetime1 - $datetime2;
}
class MensajesController extends AbstractController
{

    /**
     * @Route("/mensajes", name="mensajes", options={"expose"=true})
     */
    public function index(Request $request,ConversacionesRepository $conversacionesRepository,UserRepository $userRepository,GaleriaRepository $galeriaRepository): Response
    {


        if($request->isXMLHttpRequest()){
            $user = $this->getUser();
            $id = $user->getId();
            return new JsonResponse(['id'=>$id]);


        }else{
            $userRepository->findAll();
            $galeriaRepository->findAll();

            $conversacionesEmisor = $conversacionesRepository->findBy(
                [
                    'emisor'=>$this->getUser()

                ]
            );

            $conversacionesRemitente = $conversacionesRepository->findBy(
                [
                    'remitente' => $this->getUser()

                ]
            );

            $conversaciones = array_merge($conversacionesEmisor,$conversacionesRemitente);

            // Sort the array
            //usort($conversaciones, 'App\Controller\compararFecha');


            return $this->render('mensajes/index.html.twig', [
                'login' => $this->getUser(),
                'conversaciones' => $conversaciones,
                'request' => $request,
            ]);
            //throw new Exception("Holi :)");
        }


    }

    /**
     * @Route("/mensajes/{id}", name="conversaciones", options={"expose"=true})
     */
    public function conversaciones(Request $request,ConversacionesRepository $conversacionesRepository,MensajesRepository $mensajesRepository,UserRepository $userRepository,GaleriaRepository $galeriaRepository): Response
    {

        $userRepository->findAll();
        $galeriaRepository->findAll();

        $conversacionesEmisor = $conversacionesRepository->findBy(
            [
                'emisor'=>$this->getUser()
            ]
        );

        $conversacionesRemitente = $conversacionesRepository->findBy(
            [
                'remitente' => $this->getUser()
            ]
        );

        $conversaciones = array_merge($conversacionesEmisor,$conversacionesRemitente);

        $mensajes = $mensajesRepository->findBy(['conversacion'=>$request->attributes->get('id')]);

        // Sort the arrays
        //usort($conversaciones, 'App\Controller\compararFecha');

        return $this->render('mensajes/conversaciones.html.twig', [
            'login' => $this->getUser(),
            'conversaciones' => $conversaciones,
            'mensajes'=>$mensajes,
            'request' =>$request,

        ]);

    }
}
