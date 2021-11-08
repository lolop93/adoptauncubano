<?php

namespace App\Controller;

use App\Entity\User;
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
    public function index(MobileDetector $pantalla, Request $request): Response
    {
        $login = $this->get('security.token_storage')->getToken()->getUser();
        $query = $request->query->get('busqueda');
        $offset = max(0, $request->query->getInt('offset', 0));

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
                    'next' => min(count($paginator), $offset + self::PAGINATOR_PER_PAGE)
                ]);
            } else {
                return $this->render('busqueda/index.html.twig', [
                    'query' => $query,
                    'request' => $request,
                    'login' => $login,
                    'resultados' => $paginator,
                    'previous' => $offset - self::PAGINATOR_PER_PAGE,
                    'next' => min(count($paginator), $offset + self::PAGINATOR_PER_PAGE)
                ]);

            }
        }
        else {
                if ($pantalla->isMobile() && !$pantalla->isTablet()) {
                    return $this->render('busqueda/busquedaMobile.html.twig', [
                        'query' => $query,
                        'request' => $request,
                        'login' => $login,
                    ]);
                } else {
                    return $this->render('busqueda/index.html.twig', [
                        'query' => $query,
                        'request' => $request,
                        'login' => $login,
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


        $query = $this->getDoctrine()->getManager()
            ->createQuery(" SELECT  u.id, u.username ,u.nombre , g.foto_perfil , a.ojos, a.color_pelo, a.nacionalidad, a.fecha_nac, a.ciudad, a.altura, a.peso, a.gustos, a.profesion, a.sexo, a.descripcion from App\Entity\User u Join App\Entity\UserAttributes a with u.atributos = a.id join App\Entity\Galeria g with g.id = u.galeria WHERE u.username LIKE :query ")
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->setParameter('query', '%' . $busqueda . '%');


        return new Paginator($query);

    }
}


