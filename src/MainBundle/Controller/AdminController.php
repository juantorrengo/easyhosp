<?php

namespace MainBundle\Controller;

use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    private $repositorio = 'MainBundle:Usuario';
    
    /**
     * @Route("/miCuenta", name="miCuenta")
     */
    public function miCuentaAction()
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository($this->repositorio());
        }catch (ORMException $e){
            
        }
        return $this->render('MainBundle:Admin:micuenta.html.twig', array('user'=>$user));
    }

}
