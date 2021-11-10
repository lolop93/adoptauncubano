<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GaleriaController extends AbstractController
{
    /**
     * @Route("/galeria/delete", name="galeriaDelete", options={"expose"=true})
     */
    public function deleteFoto(Request $request): Response
    {
        if($request->isXMLHttpRequest()){
            $user = $this->getUser();
            $foto = $request->request->get('foto');
            $idFoto = $request->request->get('idFoto');
            $pathFotoDefault = $request->getBasePath() .'/images/';

            $galeria = $user->getGaleria()->getGaleria();

            //Borramos el valor del array de galeria
            if (($index = array_search($foto, $galeria)) !== false) {
                unset($galeria[$index]);
            }

            //y reordenamos el array para desplazar todos los elementos una posicion hacia atras desde el elemento borrado
            $galeria = array_values($galeria);

            $user->getGaleria()->setGaleria($galeria);

            $entityManager = $this->getDoctrine()->getManager();

            try {//Intentamos subir el mensaje
                $entityManager->persist($user);
                $entityManager->flush();

            } catch (\Exception $e) {//Si falla capturamos la excepcion y la manejamos pa que no nos la lie
                $error = '### Message ### \n'.$e->getMessage().'\n### Trace ### \n'.$e->getTraceAsString();
                $this->container->get('logger')->critical($error);
                return new JsonResponse(['error'=>$error]);//Devolvemos el error en json a jquery
            }

            return new JsonResponse(['idFoto'=>$idFoto,'galeria'=>$galeria,'foto'=>$foto,'pathFotoDefault'=>$pathFotoDefault]);//devolvemos  si ha tenido exito

        }
    }
}
