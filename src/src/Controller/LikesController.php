<?php

namespace App\Controller;

use App\Entity\Likes;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikesController extends AbstractController
{
    /**
     * @Route("/likes/set", name="likes", options={"expose"=true})
     */
    public function index(Request $request): Response
    {
        if($request->isXMLHttpRequest()){

            $emisor = $this->getUser();
            $id_receptor = $request->request->get('receptor');
            $checkLikes = $emisor->getLikesDados();

            foreach ($checkLikes as $checkLike ){
                if($checkLike->getLikesTo()->getId() == $id_receptor ){// Comprobamos Si ya le hemos dado like a ese usuario
                    $check = false;
                }else{
                    $check = true;
                }
            }

            if($check){//Si es TRUE es por que no le hemos dado me gusta

                $to = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->find($id_receptor);

                $like = new Likes();
                $like->setFecha(new \DateTime());
                $like->setLikesFrom($emisor);
                $like->setLikesTo($to);

                $entityManager = $this->getDoctrine()->getManager();

                try {//Intentamos subir el like
                    $entityManager->persist($like);
                    $entityManager->flush();

                } catch (\Exception $e) {//Si falla capturamos la excepcion y la manejamos pa que no nos la lie
                    $error = '### Message ### \n'.$e->getMessage().'\n### Trace ### \n'.$e->getTraceAsString();
                    $this->container->get('logger')->critical($error);
                    return new JsonResponse(['error'=>$error]);//Devolvemos el error en json a jquery
                }

                return new JsonResponse([/*'id'=>$id,'mensaje'=>$texto,'emisor'=>$emisor,'chat'=>$chat,'subido'=>$mensaje->getId()*/]);//devolvemos el mensaje si ha tenido exito

            }

        }
        else{
            return new Response("No me hackees pls :)");
        }
    }
}
