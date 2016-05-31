<?php

namespace MainBundle\Controller;

use Doctrine\ORM\ORMException;
use MainBundle\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    private $repositorio = 'MainBundle:Usuario';

    /**
     * @Route("/admin", name="checkLogin")
     */
    public function checkLoginAction(Request $request)
    {
        try{
            $username = $request->get('username');
            $password = $request->get('password');
            $em = $this->getDoctrine()->getManager();
            $user = $this->getDoctrine()->getRepository($this->repositorio)->findOneBy(array("email"=>$username, "password"=>$password));
            if($user){
                $session = $request->getSession();
                $session->set('id', $user->getId());
                $session->set('pass', $user->getPassword());
                $session->set('nombre', $user->getNombre());
                $session->set('apellido', $user->getApellido());
                $session->set('email', $user->getEmail());
                $session->set('isPremium', $user->getIsPremium());
                $session->set('isAdmin', $user->getIsAdmin());
                return $this->adminAction($request);
            }else{
                $this->get('session')->getFlashBag()->add('error', 'Nombre de usuario o contraseña incorrectos');
                return $this->render('MainBundle:Security:login.html.twig');
            }
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'Error inesperado, por favor intente nuevamente');
            return $this->render('MainBundle:Security:login.html.twig');
        }
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        return $this->render('MainBundle:Security:login.html.twig');
    }

    /**
     * @Route("/registrarse", name="registrarse")
     */
    public function registrarseAction()
    {
        return $this->render('MainBundle:Security:register.html.twig');
    }

    /**
     * @Route("/saveRegistro", name="saveRegistro")
     */
    public function saveRegistroAction(Request $request)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $existe = $em->getRepository($this->repositorio)->findOneByEmail($request->get('email'));
            if(!$existe){
                $usuario = new Usuario();
                $usuario->setNombre($request->get('nombre'));
                $usuario->setApellido($request->get('apellido'));
                $usuario->setEmail($request->get('email'));
                $usuario->setDireccion($request->get('direccion'));
                $usuario->setTelefono($request->get('telefono'));
                $usuario->setPassword($request->get('password'));
                $usuario->setIsAdmin(0);
                $usuario->setIsPremium(0);
                $em = $this->getDoctrine()->getManager();
                $em->persist($usuario);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'El usuario '.$usuario->getNombre().', '.$usuario->getApellido().' fue
                creado correctamente.');
                return $this->render('MainBundle:Security:login.html.twig');
            }else{
                $this->get('session')->getFlashBag()->add('error', 'El usuario con el email '.$request->get('email').' ya se 
                ecuentra registrado en el sistema.');
                return $this->render('MainBundle:Security:login.html.twig');
            }
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'Error inesperado, intente nuevamente.');
            return $this->render('MainBundle:Security:login.html.twig');
        }
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(Request $request) {
        $session = $request->getSession();
        $session->clear();
        return $this->render('MainBundle:Default:index.html.twig');
    }

    /**
     * @Route("/indexAdmin", name="admin")
     */
    public function adminAction(Request $request)
    {
        if($this->checkSession($request)){
            return $this->render('MainBundle:Admin:index.html.twig');
        }else{
            $this->get('session')->getFlashBag()->add('error', 'Error: Debe estar registrado para poder acceder.');
            return $this->render('MainBundle:Default:index.html.twig');
        }
    }

    /**
     * @Route("/changePass", name="changePass")
     */
    public function changePassAction()
    {
        return $this->render('MainBundle:Admin:cambiarPass.html.twig');
    }

    /**
     * @Route("/serPremium", name="serPremium")
     */
    public function serPremiumAction()
    {
        return $this->render('MainBundle:Admin:formPremium.html.twig');
    }

    /**
     * @Route("/serPremiumConfirm", name="serPremiumConfirm")
     */
    public function serPremiumConfirmAction(Request $request)
    {
        try{
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository($this->repositorio)->findOneById($id);
            if($usuario){
                $usuario->setisPremium(1);
                $em->persist($usuario);
                $em->flush();
                $session = $request->getSession();
                $session->clear();
                $this->get('session')->getFlashBag()->add('success', 'La categoría se cambió correctemente, ahora podés disfrutar de ser Premium!');
                return $this->render('MainBundle:Security:login.html.twig');
            }else{
                $this->get('session')->getFlashBag()->add('error', 'Error al intentar cambiar dfe categoría, intente nuevamente.');
                return $this->render('MainBundle:Admin:micuenta.html.twig', array('user'=>$usuario));
            }
        }catch (ORMException $e){
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository($this->repositorio)->findOneById($id);
            $this->get('session')->getFlashBag()->add('error', 'Error inesperado, intente nuevamente.');
            return $this->render('MainBundle:Admin:micuenta.html.twig', array('user'=>$usuario));
        }
    }

    /**
     * @Route("/changePassConfirm", name="changePassConfirm")
     */
    public function changePassConfirmAction(Request $request)
    {
        try{
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository($this->repositorio)->findOneById($id);
            if($usuario){
                $usuario->setPassword($request->get('password'));
                $em->persist($usuario);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'La contraseña fue cambiada correctamente.');
                $session = $request->getSession();
                $session->clear();
                return $this->render('MainBundle:Security:login.html.twig');
            }else{
                $this->get('session')->getFlashBag()->add('error', 'Error al cambiar la contraseña, intente nuevamente.');
                return $this->render('MainBundle:Admin:micuenta.html.twig', array('user'=>$usuario));
            }
        }catch (ORMException $e){
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository($this->repositorio)->findOneById($id);
            $this->get('session')->getFlashBag()->add('error', 'Error inesperado, intente nuevamente.');
            return $this->render('MainBundle:Admin:micuenta.html.twig', array('user'=>$usuario));
        }
    }


    private function checkSession(Request $request){
        $session = $request->getSession();
        if($session->has("id")){
            $condicion = true;
        }else{
            $condicion = false;
        }
        return $condicion;
    }


}
