<?php
namespace MainBundle\Controller;
use Doctrine\ORM\ORMException;
use MainBundle\Entity\PreguntaSeguridad;
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
            $user = $em->getRepository($this->repositorio)->findOneBy(array("email"=>$username, "password"=>$password));
            if($user){
                if($user->getBorrado()== 0){
                    $session = $request->getSession();
                    $session->set('id', $user->getId());
                    $session->set('pass', $user->getPassword());
                    $session->set('nombre', $user->getNombre());
                    $session->set('apellido', $user->getApellido());
                    $session->set('email', $user->getEmail());
                    $session->set('isPremium', $user->getIsPremium());
                    $session->set('isAdmin', $user->getIsAdmin());
                    return $this->redirect($this->generateUrl('home'));
                }else{
                    $this->get('session')->getFlashBag()->add('error', 'El usuario está dado de baja en el sistema, comuniquese con un administrador.');
                    return $this->render('MainBundle:Security:login.html.twig');
                }
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
        $em = $this->getDoctrine()->getManager();
        $preguntas = $em->getRepository('MainBundle:PreguntaSeguridad')->findAll();
        return $this->render('MainBundle:Security:register.html.twig', array('preguntas'=>$preguntas));
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
                $usuario->setPreguntaSecreta($request->get('pregunta'));
                $usuario->setRespuestaSeguridad($request->get('respuesta'));
                $usuario->setIsAdmin(0);
                $usuario->setBorrado(0);
                $usuario->setFechaAlta(new \DateTime());
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
        return $this->redirect($this->generateUrl('home'));
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
                $request->getSession()->set('isPremium', 1);
                $this->get('session')->getFlashBag()->add('success', 'La categoría se cambió correctemente, ahora podés disfrutar de ser Premium!');
                return $this->render('MainBundle:Admin:micuenta.html.twig', array('user'=>$usuario));
            }else{
                $this->get('session')->getFlashBag()->add('error', 'Error al intentar cambiar de categoría, intente nuevamente.');
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
                $request->getSession()->set('pass', $request->get('password'));
                return $this->render('MainBundle:Admin:micuenta.html.twig', array('user'=>$usuario));
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
    /**
     * @Route("/serPremium", name="serPremium")
     */
    public function serPremiumAction()
    {
        return $this->render('MainBundle:Admin:formPremium.html.twig');
    }
    /**
     * @Route("/recuperarClave", name="recuperarClave")
     */
    public function recuperarClaveAction()
    {
        return $this->render('MainBundle:Admin:formRecuperar.html.twig');
    }

    /**
     * @Route("/recuperarPass/{email}", name="recuperarPass")
     * @param $email
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function recuperarPassAction($email)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('MainBundle:Usuario')->findOneByEmail($email);
            if(!$user){
                $array = array('status'=> 400, 'msg'=>'Usuario no encontrado');
            }else{
                $em = $this->getDoctrine()->getManager();
                $pregunta = $em->getRepository('MainBundle:PreguntaSeguridad')->findOneById($user->getPreguntaSecreta());
                return $this->render('MainBundle:Admin:formRecuperar.html.twig', array('pregunta'=>$pregunta, 'email' =>$user->getEmail()));
            }
        }catch (Exception $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }



    /**
     * @Route("/recuperarPassConfirm", name="recuperarPassConfirm")
     */
    public function recuperarPassConfirmAction(Request $request)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository($this->repositorio)->findOneBy(array('email'=>$request->get('email'), 'respuestaSeguridad'=>$request->get('respuesta')));
            if (!$user){
                $this->get('session')->getFlashBag()->add('error', 'La respuesta es incorrecta, intente nuevamente');
                return $this->render('MainBundle:Security:login.html.twig');
            }else{
                return $this->render('MainBundle:Security:passRecuperada.html.twig', array('user'=>$user));
            }
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'Error inesperado, intente nuevamente.');
            return $this->render('MainBundle:Security:login.html.twig');
        }
    }

    /**
     * @Route("/savePassRecuperada", name="savePassRecuperada")
     */
    public function savePassRecuperadaAction(Request $request)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository($this->repositorio)->findOneById($request->get('userId'));
            if (!$user){
                $this->get('session')->getFlashBag()->add('error', 'Usuario no encontrado');
                return $this->render('MainBundle:Security:login.html.twig');
            }else{
                $user->setPassword($request->get('password'));
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'su contraseña ha sido modificada correctamente.');
                return $this->render('MainBundle:Security:login.html.twig');
            }
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'Error inesperado, intente nuevamente.');
            return $this->render('MainBundle:Security:login.html.twig');
        }
    }
}
