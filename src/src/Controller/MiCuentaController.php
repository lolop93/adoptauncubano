<?php

namespace App\Controller;

use App\Entity\UserAttributes;
use App\Entity\User;
use App\Form\UserAttributesFormType;
use App\Form\UserFormType;
use App\Repository\GaleriaRepository;
use App\Repository\UserAttributesRepository;
use App\Repository\UserRepository;
use Detection\MobileDetect;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//use SunCat\MobileDetectBundle\MobileDetectBundle;
use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;
use Symfony\Component\Validator\Constraints\Date;


class MiCuentaController extends AbstractController
{
    //#[Route('/cuenta', name: 'mi_cuenta')]
    public function index(): Response
    {
        return $this->render('mi_cuenta/index.html.twig', [
            'controller_name' => 'MiCuentaController',
        ]);
    }

    #[Route('/cuenta/perfil', name: 'perfil')]
    public function perfil(MobileDetector $pantalla, UserRepository $userRepository, GaleriaRepository $galeriaRepository, UserAttributesRepository $userAttributesRepository): Response
    {
        $login = $this->get('security.token_storage')->getToken()->getUser();
        $galeriaRepository->findAll();
        $userAttributesRepository->findAll();

        //$mobileDetector = $this->get('mobile_detect.mobile_detector');

        $age = new \DateTime();//Pasamos la fecha en la que nació a Edad normal
        $a = ($login->getAtributos() && $login->getAtributos()->getFechaNac() ? date_diff($age, $login->getAtributos()->getFechaNac()) : "");

        if($pantalla->isMobile() && !$pantalla->isTablet()){
            return $this->render('mi_cuenta/perfilMobile.html.twig', [
                'login' => $login,
                'edad' =>  $a,
            ]);
        }else {
            return $this->render('mi_cuenta/perfil.html.twig', [
                'login' => $login,
                'edad' =>  $a,
            ]);
        }
    }

    #[Route('/cuenta/perfil/editar', name: 'editarperfil')]
    public function editarperfil(Request $request, MobileDetector $pantalla, UserRepository $userRepository, GaleriaRepository $galeriaRepository, UserAttributesRepository $userAttributesRepository): Response
    {
        $login = $this->get('security.token_storage')->getToken()->getUser();
        $galeriaRepository->findAll();
        $userAttributesRepository->findAll();

        //Creamos un objeto atributo y se lo pasamos al objeto formulario de tipo "formulario de atributos"
        $atributos = new UserAttributes();

        $form = $this->createForm(UserAttributesFormType::class, $atributos);//Creamos el formulario y lo guardamos en una variable
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $atributos = $form->getData();
            $login->setAtributos($atributos);

            $entityManager->persist($login);
            $entityManager->persist($atributos);
            $entityManager->flush();

            return $this->redirectToRoute('perfil');
        }
        else{
            if ($pantalla->isMobile() && !$pantalla->isTablet()) {
                return $this->render('mi_cuenta/perfilMobileEditar.html.twig', [
                    'login' => $login,
                    'form_atributos' => $form->createView()
                ]);
            } else {
                return $this->render('mi_cuenta/perfilEditar.html.twig', [
                    'login' => $login,
                    'form_atributos' => $form->createView()
                ]);
            }
        }
    }


    #[Route('/cuenta/ajustes', name: 'ajustes')]
    public function ajustes(MobileDetector $pantalla): Response
    {
        $login = $this->get('security.token_storage')->getToken()->getUser();


        if($pantalla->isMobile() && !$pantalla->isTablet()){
            return $this->render('mi_cuenta/ajustesMobile.html.twig', [
                'login' => $login,
            ]);
        }else {
            return $this->render('mi_cuenta/ajustes.html.twig', [
                'login' => $login,
            ]);
        }
    }

    #[Route('/cuenta/ajustes/editar', name: 'editarajustes')]
    public function editarajustes(Request $request, MobileDetector $pantalla): Response
    {
        $login = $this->get('security.token_storage')->getToken()->getUser();

        //Creamos un objeto user y se lo pasamos al objeto formulario de tipo "formulario de atributos"
        $usuario = new User();

        $form = $this->createForm(UserFormType::class, $usuario);//Creamos el formulario y lo guardamos en una variable
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $datosUsuario = $form->getData();
            $login->setNombre($datosUsuario->getNombre());
            $login->setApellido1($datosUsuario->getApellido1());
            $login->setEmail($datosUsuario->getEmail());
            $entityManager->persist($login);
            $entityManager->flush();

            return $this->redirectToRoute('editarajustes');
        }
        else{
            if ($pantalla->isMobile() && !$pantalla->isTablet()) {
                return $this->render('mi_cuenta/ajustesMobileEditar.html.twig', [
                    'login' => $login,
                    'form_ajustes' => $form->createView()
                ]);
            } else {
                return $this->render('mi_cuenta/ajustesEditar.html.twig', [
                    'login' => $login,
                    'form_ajustes' => $form->createView()
                ]);
            }
        }
    }
}
