<?php

namespace App\Controller;

use App\Entity\Conversaciones;
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
     * @Route("/likes/set", name="setLikes", options={"expose"=true})
     */
    public function index(Request $request): Response
    {
        if($request->isXMLHttpRequest()){

            $emisor = $this->getUser();
            $id_receptor = $request->request->get('receptor');
            $checkLikesTo = $emisor->getLikesDados();
            $checkLikesFrom = $emisor->getLikesRecibidos();

            if($checkLikesTo->isEmpty()) {//Si no le ha dado me gusta a ningun usuario , directamente es false
                $checkTo = False;
            }else{
                foreach ($checkLikesTo as $checkLikeTo) { //comprobamos a quien ha dado me gusta el usuario
                    if ($checkLikeTo->getLikesTo()->getId() == $id_receptor) {// Comprobamos Si ya le hemos dado like a ese usuario
                        $checkTo = True;
                    } else {
                        $checkTo = False;
                    }
                }
            }

            if($checkLikesFrom->isEmpty()) {//Si no nos ha dado me gusta ningun usuario , directamente es false
                $checkFrom = False;
            }else {
                foreach ($checkLikesFrom as $checkLikeFrom) { //comprobamos quien ha dado me gusta al usuario, por si es el mismo al que tu le das me gusta
                    if ($checkLikeFrom->getLikesFrom()->getId() == $id_receptor) {// Comprobamos si nos ha dado like ese usuario
                        $checkFrom = True;
                    } else {
                        $checkFrom = False;
                    }
                }
            }

            if(!$checkTo){//Si es FALSE es por que no le hemos dado me gusta asi que lo negamos con '!' para que entre en el if()

                $to = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->find($id_receptor);

                $like = new Likes();
                $like->setFecha(new \DateTime());
                $like->setLikesFrom($emisor);
                $like->setLikesTo($to);

                $entityManager = $this->getDoctrine()->getManager();

                try {//Intentamos subir el like y crear la conversacion si fuese necesario
                    $entityManager->persist($like);

                    if($checkFrom){//si es TRUE es porque tambien nos ha dado me gusta asi que hay que crear una conversación
                        $conversacion = new Conversaciones();
                        $conversacion->setFecha(new \DateTime());
                        $conversacion->setFechaCreacion(new \DateTime());
                        $conversacion->setEmisor($emisor);
                        $conversacion->setRemitente($to);
                        $entityManager->persist($conversacion);
                    }

                    $entityManager->flush();

                } catch (\Exception $e) {//Si falla capturamos la excepcion y la manejamos pa que no nos la lie
                    $error = '### Message ### \n'.$e->getMessage().'\n### Trace ### \n'.$e->getTraceAsString();
                    $this->container->get('logger')->critical($error);
                    return new JsonResponse(['error'=>$error]);//Devolvemos el error en json a jquery
                }

                return new JsonResponse([/*'id'=>$id,'mensaje'=>$texto,'emisor'=>$emisor,'chat'=>$chat,'subido'=>$mensaje->getId()*/]);//devolvemos el mensaje si ha tenido exito

            }else{//Si ya le ha dado me gusta, Devuelve un json diciendo que ya le ha dado me gusta
                return new JsonResponse(['KO'=>'Ya le has dado me gusta']);
            }

        }
        else{
            return new Response("No me hackees pls :)");
        }
    }
}
