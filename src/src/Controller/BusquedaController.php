<?php

namespace App\Controller;

use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BusquedaController extends AbstractController
{
    #[Route('/busqueda', name: 'busqueda', methods: ['GET'])]
    public function index(MobileDetector $pantalla, Request $request): Response
    {
        $login = $this->get('security.token_storage')->getToken()->getUser();
        $query = $request->query->get('busqueda');

        if($pantalla->isMobile() && !$pantalla->isTablet()){
            return $this->render('busqueda/busquedaMobile.html.twig', [
                'query' => $query,
                'request'=> $request,
                'login' => $login,
            ]);
        }else {
            return $this->render('busqueda/index.html.twig', [
                'query' => $query,
                'request'=> $request,
                'login' => $login,
            ]);
        }


    }

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
}


