<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\LikesRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Psr\Container\ContainerInterface;
use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BusquedaController extends AbstractController
{
    public const PAGINATOR_PER_PAGE = 5;

    #[Route('/busqueda', name: 'busqueda', methods: ['GET','POST'])]
    public function index(MobileDetector $pantalla, Request $request, LikesRepository $likesRepository): Response
    {
        $login = $this->get('security.token_storage')->getToken()->getUser();
        $query = $request->query->get('busqueda');
        $offset = max(0, $request->query->getInt('offset', 0));
        $likes = $likesRepository->findAll();
        $likesRecibidos = $login->getLikesRecibidos();
        $likesDados = $login->getLikesDados();

        if($likesDados->count() > 0){//comprobamos que ha dado me gusta a alguien al menos
            foreach ($likesDados as $likesDado){
                $likesTotales[]= $likesDado->getLikesTo()->getId(); //los Likes dados son likes en los que $likesTo es el otro usuario
            }
        }else{//Si tampoco le ha dado me gusta a nadie
            $likesTotales = array(); //creamos un array vacio
        }

        if ($request->isMethod('GET') || $request->isMethod('POST')) {

            /*$em = $this -> getDoctrine()->getManager();
            $res = $em->createQuery(" SELECT  u.username ,u.nombre , a.ojos , g.foto_perfil from App\Entity\User u Join App\Entity\UserAttributes a with u.atributos = a.id join App\Entity\Galeria g with g.id = u.galeria WHERE u.username LIKE :query ")
                ->setParameter('query', '%' . $query . '%');
            $result = $res->getResult();*/


            $paginator = $this->getBusquedaPaginator($offset, $query);
            $paginator->setUseOutputWalkers(false);//Pa arreglar un fallo que sale por hacer una consulta tocha


            if ($pantalla->isMobile() && !$pantalla->isTablet()) {
                return $this->render('busqueda/busquedaMobile.html.twig', [
                    'query' => $query,
                    'request' => $request,
                    'login' => $login,
                    'resultados' => $paginator,
                    'previous' => $offset - self::PAGINATOR_PER_PAGE,
                    'next' => min(count($paginator), $offset + self::PAGINATOR_PER_PAGE),
                    'likesTotales' => $likesTotales,
                ]);
            } else {
                return $this->render('busqueda/index.html.twig', [
                    'query' => $query,
                    'request' => $request,
                    'login' => $login,
                    'resultados' => $paginator,
                    'previous' => $offset - self::PAGINATOR_PER_PAGE,
                    'next' => min(count($paginator), $offset + self::PAGINATOR_PER_PAGE),
                    'likesTotales' => $likesTotales,
                ]);

            }
        }
        else {
                if ($pantalla->isMobile() && !$pantalla->isTablet()) {
                    return $this->render('busqueda/busquedaMobile.html.twig', [
                        'query' => $query,
                        'request' => $request,
                        'login' => $login,
                        'likesTotales' => $likesTotales,
                    ]);
                } else {
                    return $this->render('busqueda/index.html.twig', [
                        'query' => $query,
                        'request' => $request,
                        'login' => $login,
                        'likesTotales' => $likesTotales,
                    ]);
                }
            }
        }



    //Es una forma NO IMPLEMENTADA  que probé y funciona para insertar un cacho de formulario en cualkier lao
    public function barraBusqueda(){

        $form = $this->createFormBuilder(null)
            ->setAction($this->generateUrl('busqueda'))
            ->setMethod('GET')
            ->add('query', TextType::class)
            ->add('submit',SubmitType::class)
            ->getForm();

        /*$form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Los datos están en un array con los keys "name", "email", y "message"
            $data = $form->getData();
         }*/

        return $this->render('busqueda/barraBusqueda.html.twig', [
            'form' => $form->createView()
        ]);

    }

    public function getBusquedaPaginator(int $offset, $busqueda): Paginator{


        $palabritas = explode(' ', $busqueda);

        $querycompleta = " SELECT  u.id, u.username ,u.nombre , g.foto_perfil , a.ojos, a.color_pelo, a.nacionalidad, a.fecha_nac, a.ciudad, a.altura, a.peso, a.gustos, a.profesion, a.sexo, a.descripcion from App\Entity\User u Join App\Entity\UserAttributes a with u.atributos = a.id join App\Entity\Galeria g with g.id = u.galeria ";

        $querycompleta .= "WHERE (";

        count($palabritas);
        $cont = 0;

        foreach ($palabritas as $palabra){
            $cont++; //para contar cuantos OR concatenamos

            $querycompleta .= " u.username LIKE '%".$palabra."%' OR u.nombre LIKE '%".$palabra."%' OR a.ojos LIKE '%".$palabra."%' OR a.color_pelo LIKE '%".$palabra."%' OR a.ciudad LIKE '%".$palabra."%' OR a.gustos LIKE '%".$palabra."%' OR a.profesion LIKE '%".$palabra."%' OR a.descripcion LIKE '%".$palabra."%' ";

            if($cont <  count($palabritas)){
                $querycompleta .= " OR ";
            }
        }
        $querycompleta .= ")";


        $query = $this->getDoctrine()->getManager()
            ->createQuery($querycompleta)
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset);
            //->setParameter('query', '%' . $busqueda . '%');


        return new Paginator($query);

    }
}


