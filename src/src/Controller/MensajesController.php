<?php

namespace App\Controller;



use App\Entity\Conversaciones;
use App\Entity\Mensajes;
use App\Entity\User;
use App\Repository\ConversacionesRepository;
use App\Repository\GaleriaRepository;
use App\Repository\MensajesRepository;
use App\Repository\UserAttributesRepository;
use App\Repository\UserRepository;
use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;
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
    public function index(MobileDetector $pantalla,Request $request,ConversacionesRepository $conversacionesRepository,UserRepository $userRepository,GaleriaRepository $galeriaRepository): Response
    {

        if($request->isXMLHttpRequest()){
            $user = $this->getUser();
            $id = $user->getId();
            $texto = $request->request->get('texto');
            $emisor = $request->request->get('emisor');
            $chat = $request->request->get('chat');

            $mensaje = new Mensajes();

            $conversacion = $this->getDoctrine()
                ->getRepository(Conversaciones::class)
                ->find($chat);

            $usuario = $this->getDoctrine()
                ->getRepository(User::class)
                ->find($emisor);

            $mensaje->setTexto($texto);
            $mensaje->setConversacion($conversacion);
            $mensaje->setUsuario($usuario);
            $mensaje->setFecha(new \DateTime());


            $entityManager = $this->getDoctrine()->getManager();

            try {//Intentamos subir el mensaje
                $entityManager->persist($mensaje);
                $entityManager->flush();

            } catch (\Exception $e) {//Si falla capturamos la excepcion y la manejamos pa que no nos la lie
                $error = '### Message ### \n'.$e->getMessage().'\n### Trace ### \n'.$e->getTraceAsString();
                $this->container->get('logger')->critical($error);
                return new JsonResponse(['id'=>$id,'mensaje'=>$texto,'emisor'=>$emisor,'chat'=>$chat,'error'=>$error]);//Devolvemos el error en json a jquery
            }

            return new JsonResponse(['id'=>$id,'mensaje'=>$texto,'emisor'=>$emisor,'chat'=>$chat,'subido'=>$mensaje->getId()]);//devolvemos el mensaje si ha tenido exito


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

            if($pantalla->isMobile() && !$pantalla->isTablet()){
                return $this->render('mensajes/indexMobile.html.twig', [
                    'login' => $this->getUser(),
                    'conversaciones' => $conversaciones,
                    'request' => $request,
                ]);
            }else {
                return $this->render('mensajes/index.html.twig', [
                    'login' => $this->getUser(),
                    'conversaciones' => $conversaciones,
                    'request' => $request,
                ]);
            }

            //throw new Exception("Holi :)");
        }


    }

    /**
     * @Route("/mensajes/{id}", name="conversaciones", options={"expose"=true})
     */
    public function conversaciones(MobileDetector $pantalla, Request $request,ConversacionesRepository $conversacionesRepository,MensajesRepository $mensajesRepository,UserRepository $userRepository,GaleriaRepository $galeriaRepository): Response
    {

        $userRepository->findAll();
        $galeriaRepository->findAll();

        $conversacionesEmisor = $conversacionesRepository->findBy(['emisor'=>$this->getUser()]);
        $conversacionesRemitente = $conversacionesRepository->findBy(['remitente' => $this->getUser()]);
        $conversaciones = array_merge($conversacionesEmisor,$conversacionesRemitente);

        $mensajes = $mensajesRepository->findBy(['conversacion'=>$request->attributes->get('id')]);
        if($mensajes[0]->getConversacion()->getRemitente()->getId()==$this->getUser()->getId()){
            $nombreOtro = $mensajes[0]->getConversacion()->getEmisor()->getUsername();
        }else{
            $nombreOtro= $mensajes[0]->getConversacion()->getRemitente()->getUsername();
        }
        // Sort the arrays
        //usort($conversaciones, 'App\Controller\compararFecha');

        if($pantalla->isMobile() && !$pantalla->isTablet()){
            return $this->render('mensajes/conversacionesMobile.html.twig', [
                'login' => $this->getUser(),
                'mensajes'=>$mensajes,
                'conversaciones' => $conversaciones,
                'request' => $request,
                'nombreOtro' => $nombreOtro

            ]);
        }else {
            return $this->render('mensajes/conversaciones.html.twig', [
                'login' => $this->getUser(),
                'mensajes'=>$mensajes,
                'conversaciones' => $conversaciones,
                'request' => $request,
                'nombreOtro' => $nombreOtro
            ]);
        }


    }

    /**
     * @Route("/getmensajes", name="consultarMensajes", options={"expose"=true})
     */
    public function consultarMensajes(Request $request,MensajesRepository $mensajesRepository): Response
    {
        if($request->isXMLHttpRequest()){
            //consultamos si un usuario con una id tiene alguna conversacion con esa id
            $user = $this->getUser();
            $id = $user->getId();
            $chat = $request->request->get('chat');

            $conversacion = $this->getDoctrine()
                ->getRepository(Conversaciones::class)
                ->find($chat);

            $mensajes = $mensajesRepository->findBy(
                array('conversacion' => $conversacion->getId()),
            );

            foreach($conversacion->getMensajes() as $mensaje){
                //var_dump($mensaje)
                if($mensaje->getUsuario()->getId()!=$id){
                    $mensajes[] = [
                        'id' => $mensaje->getId(),
                        'texto' => $mensaje->getTexto()
                    ];
                }

            }

            return new JsonResponse(['id_conversacion'=>$conversacion->getId(),'mensajes'=>$mensajes]);//devolvemos el mensaje, junto a la id del ultimo mensaje del otro usuario y la id de la conversacion si ha tenido exito


        }
    }
}
