<?php

namespace MainBundle\Controller;

use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class UsuarioController extends Controller
{
    private $repositorio = 'MainBundle:Usuario';

    /**
     * @Route("/miCuenta", name="miCuenta")
     */
    public function miCuentaAction(Request $request)
    {
        try{
            $session = $request->getSession();
            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository($this->repositorio)->findOneById($session->get('id'));
            if(!$usuario){
                $this->get('session')->getFlashBag()->add('error', 'Error, no se encontró el usuario.');
                return $this->generateUrl('admin', array('request' => $request));
            }else{
                return $this->render('MainBundle:Admin:micuenta.html.twig', array('user'=>$usuario));
            }
        }catch (ORMException $e){

        }
    }

    /**
     * @Route("/saveEditUser", name="saveEditUser")
     */
    public function saveEditUserAction(Request $request)
    {
        try{
            $session = $request->getSession();
            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository($this->repositorio)->findOneById($session->get('id'));
            if(!$usuario){
                $this->get('session')->getFlashBag()->add('error', 'Error, no se encontró el usuario.');
                return $this->generateUrl('admin', array('request' => $request));
            }else{
                $usuario->setNombre($request->get('nombre'));
                $usuario->setApellido($request->get('apellido'));
                $usuario->setEmail($request->get('email'));
                $usuario->setDireccion($request->get('direccion'));
                $usuario->setTelefono($request->get('telefono'));
                $usuario->setIsAdmin(0);
                $usuario->setIsPremium(0);
                $em = $this->getDoctrine()->getManager();
                $em->persist($usuario);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'El usuario '.$usuario->getNombre().', '.$usuario->getApellido().' fue
                editado correctamente.');
                return $this->render('MainBundle:Admin:micuenta.html.twig', array('user'=>$usuario));
            }
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'Error inesperado, intente nuevamente.');
            return $this->render('MainBundle:Security:login.html.twig');
        }
    }

}
