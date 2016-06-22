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
     * @Route("/misFavoritos", name="misFavoritos")
     */
    public function misFavsAction(Request $request)
    {
        try{
            $session = $request->getSession();
            $userId = $session->get('id');
            $em = $this->getDoctrine()->getManager();
            $hospedajes= $em->getRepository('MainBundle:Hospedaje')->findHospedajeUsuario($userId);
            $em = $this->getDoctrine()->getManager();
            $favoritos = $em->getRepository('MainBundle:Favorito')->findBy(array('usuario'=>$userId));
            if(!$hospedajes){
                $this->get('session')->getFlashBag()->add('error', 'Error, no se encontró el usuario.');
                return $this->redirect($this->generateUrl('home', array('request' => $request, 'page'=>1)));
            }else{
                return $this->render('MainBundle:Admin:misFavoritos.html.twig', array('hospedajes'=>$hospedajes, 'favoritos'=>$favoritos));
            }
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'Error, no se encontró el usuario.');
            return $this->redirect($this->generateUrl('home', array('request' => $request, 'page'=>1)));
        }
    }


    /**
     * @Route("/favoritos", name="favs")
     */
    public function misFavoritosAction(Request $request)
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
                if($request->get('dni') != ""){
                    $usuario->setDni($request->get('dni'));
                }
                if($request->get('sexo') != ""){
                    $usuario->setSexo($request->get('sexo'));
                }
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
