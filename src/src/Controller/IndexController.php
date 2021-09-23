<?php

namespace App\Controller;

use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(MobileDetector $pantalla): Response
    {
        if($pantalla->isMobile() && !$pantalla->isTablet()){
            return $this->render('index/indexMobile.html.twig');
        }else {
            return $this->render('index/index.html.twig',);
        }
    }


}
