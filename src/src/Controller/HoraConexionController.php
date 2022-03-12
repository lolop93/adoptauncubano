<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HoraConexionController extends AbstractController
{
    /**
     * @Route("/conectado/set", name="setConectado", options={"expose"=true})
     */
    public function index(Request $request): Response
    {

        $usuario = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $usuario->setHoraconexion(new \DateTime());

        try {
            $entityManager->persist($usuario);
            $entityManager->flush();

        } catch (\Exception $e) {//Si falla capturamos la excepcion y la manejamos pa que no nos la lie
            $error = '### Message ### \n'.$e->getMessage().'\n### Trace ### \n'.$e->getTraceAsString();
            $this->container->get('logger')->critical($error);
            return new JsonResponse(['error'=>$error]);//Devolvemos el error en json a jquery
        }

        return new Response("correcto");
    }
}
