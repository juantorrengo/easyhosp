<?php

namespace MainBundle\Controller;

use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class HospedajeController extends Controller
{
    private $repositorio = 'MainBundle:Hospedaje';

    /**
     * @Route("/misHospedajes", name="misHospedajes")
     */
    public function misHospedajesAction(Request $request){
        try{
            $userId = $request->getSession()->get('id');
            $em = $this->getDoctrine()->getManager();
            $hospedajes = $this->getDoctrine()->getRepository('MainBundle:Hospedaje')->findByUsuario($userId);
            return $this->render('MainBundle:Admin:index.html.twig', array('hospedajes'=>$hospedajes));
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'Error inesperado, por favor intente nuevamente');
            return $this->render('MainBundle:Security:login.html.twig');
        }
    }

}
