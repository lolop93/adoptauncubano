<?php

namespace App\Controller;

use App\Entity\Galeria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
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
        else{
            throw new Exception("Holi :)");
        }
    }

    /**
     * @Route("/galeria/upload", name="galeriaUpload", options={"expose"=true})
     */
    public function uploadFoto(Request $request): Response
    {
        if($request->isXMLHttpRequest()){

            $user = $this->getUser();
            $foto = $request->files->get('file');
            $filename = md5(uniqid()).'.'.$foto->guessExtension();
            $pathFoto = $this->getParameter('kernel.project_dir') .'\\public\images\Perfiles\\';
            $urlPhoto =  $request->getBasePath() .'/images/Perfiles/';

            $foto->move($pathFoto, $filename);

            if($user->getGaleria()){

                $galeriaUser = $user->getGaleria()->getGaleria();
                array_push($galeriaUser, $filename);
                $user->getGaleria()->setGaleria($galeriaUser);
                $entityManager = $this->getDoctrine()->getManager();

                try {//Intentamos subir la foto
                    $entityManager->persist($user);
                    $entityManager->flush();

                } catch (\Exception $e) {//Si falla capturamos la excepcion y la manejamos pa que no nos la lie
                    $error = '### Message ### \n'.$e->getMessage().'\n### Trace ### \n'.$e->getTraceAsString();
                    return new JsonResponse(['error'=>$error,'subido'=>'ko']);//Devolvemos el error en json a jquery
                }

                return new JsonResponse(['subido'=>'ok','errores'=> $foto->getErrorMessage(),'pathFoto'=>$urlPhoto,'nombreFoto'=>$filename,"n" => $_FILES['file']['tmp_name']]);
            }else{
                $nuevaGaleria = new Galeria();
                $nuevaGaleria->setGaleria(array($filename));
                $user->setGaleria($nuevaGaleria);
                $entityManager = $this->getDoctrine()->getManager();

                try {//Intentamos subir la foto
                    $entityManager->persist($user);
                    $entityManager->persist($nuevaGaleria);
                    $entityManager->flush();

                } catch (\Exception $e) {//Si falla capturamos la excepcion y la manejamos pa que no nos la lie
                    $error = '### Message ### \n'.$e->getMessage().'\n### Trace ### \n'.$e->getTraceAsString();
                    $this->container->get('logger')->critical($error);
                    return new JsonResponse(['error'=>$error,'subido'=>'ko']);//Devolvemos el error en json a jquery
                }

                return new JsonResponse(['subido'=>'ok','urlFoto'=> $filename]);
            }

        }
        else{
            throw new Exception("Holi :)");
        }
    }


    /**
     * @Route("/fotoPerfil/delete", name="fotoPerfilDelete", options={"expose"=true})
     */
    public function deleteFotoPerfil(Request $request): Response
    {
        if($request->isXMLHttpRequest()){
            $user = $this->getUser();
            $foto = $request->request->get('foto');
            $idFoto = $request->request->get('idFoto');
            $pathFotoDefault = $request->getBasePath() .'/images/';

            $galeria = $user->getGaleria()->getFotoPerfil();

            //Borramos el valor de la foto de perfil
            $fotoPerfil = '';

            $user->getGaleria()->setFotoPerfil($fotoPerfil);

            $entityManager = $this->getDoctrine()->getManager();

            try {//Intentamos subir el mensaje
                $entityManager->persist($user);
                $entityManager->flush();

            } catch (\Exception $e) {//Si falla capturamos la excepcion y la manejamos pa que no nos la lie
                $error = '### Message ### \n'.$e->getMessage().'\n### Trace ### \n'.$e->getTraceAsString();
                $this->container->get('logger')->critical($error);
                return new JsonResponse(['error'=>$error]);//Devolvemos el error en json a jquery
            }

            return new JsonResponse(['idFoto'=>$idFoto,'galeria'=>$fotoPerfil,'foto'=>$foto,'pathFotoDefault'=>$pathFotoDefault]);//devolvemos  si ha tenido exito

        }
        else{
            throw new Exception("Holi :)");
        }
    }

    /**
     * @Route("/fotoPerfil/upload", name="fotoPerfilUpload", options={"expose"=true})
     */
    public function uploadFotoPerfil(Request $request): Response
    {
        if($request->isXMLHttpRequest()){

            $user = $this->getUser();
            $foto = $request->files->get('file');
            $filename = md5(uniqid()).'.'.$foto->guessExtension();
            $pathFoto = $this->getParameter('kernel.project_dir') .'\\public\images\Perfiles\\';
            $urlPhoto =  $request->getBasePath() .'/images/Perfiles/';

            $foto->move($pathFoto, $filename);

            if($user->getGaleria()){

                $user->getGaleria()->setFotoPerfil($filename);
                $entityManager = $this->getDoctrine()->getManager();

                try {//Intentamos subir la foto
                    $entityManager->persist($user);
                    $entityManager->flush();

                } catch (\Exception $e) {//Si falla capturamos la excepcion y la manejamos pa que no nos la lie
                    $error = '### Message ### \n'.$e->getMessage().'\n### Trace ### \n'.$e->getTraceAsString();
                    return new JsonResponse(['error'=>$error,'subido'=>'ko']);//Devolvemos el error en json a jquery
                }

                return new JsonResponse(['subido'=>'ok','errores'=> $foto->getErrorMessage(),'pathFoto'=>$urlPhoto,'nombreFoto'=>$filename,"n" => $_FILES['file']['tmp_name']]);
            }else{
                $nuevaGaleria = new Galeria();
                $nuevaGaleria->setFotoPerfil($filename);
                $entityManager = $this->getDoctrine()->getManager();

                try {//Intentamos subir la foto
                    $entityManager->persist($user);
                    $entityManager->persist($nuevaGaleria);
                    $entityManager->flush();

                } catch (\Exception $e) {//Si falla capturamos la excepcion y la manejamos pa que no nos la lie
                    $error = '### Message ### \n'.$e->getMessage().'\n### Trace ### \n'.$e->getTraceAsString();
                    $this->container->get('logger')->critical($error);
                    return new JsonResponse(['error'=>$error,'subido'=>'ko']);//Devolvemos el error en json a jquery
                }

                return new JsonResponse(['subido'=>'ok','urlFoto'=> $filename]);
            }

        }
        else{
            throw new Exception("Holi :)");
        }
    }
}
