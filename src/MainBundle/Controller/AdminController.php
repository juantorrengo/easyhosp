<?php

namespace MainBundle\Controller;

use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{

    /**
     * @Route("/usuarios", name="usuarios", options={"expose"=true})
     */
    public function usuariosAction()
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $usuarios = $em->getRepository('MainBundle:Usuario')->findAll();
            return $this->render('MainBundle:Admin:usuarios.html.twig', array('usuarios'=>$usuarios));
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'Error inesperado, por favor intente nuevamente');
            return $this->redirect($this->generateUrl('home'));
        }
    }

    /**
     * @Route("/msgBaja/{id}", name="msgBaja", options={"expose"=true})
     */
    public function msgBajaAction($id)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository('MainBundle:Usuario')->findOneById($id);
            return $this->render('MainBundle:Admin:msjBaja.html.twig', array('u'=>$usuario));
        }catch (ORMException $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/confirmarBaja", name="confimarBaja")
     */
    public function confirmarBajaAction(Request $request)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository('MainBundle:Usuario')->findOneById($request->get('userId'));
            $usuario->setBorrado(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'El usuario '.$usuario->getEmail().' fue dado de baja correctamente');
            return $this->redirect($this->generateUrl('usuarios'));
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'Error al intentar dar der de baja al usuario.');
            return $this->redirect($this->generateUrl('home'));
        }
    }

}
