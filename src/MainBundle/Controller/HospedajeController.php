<?php

namespace MainBundle\Controller;

use Doctrine\ORM\ORMException;
use easyhosp\MainBundle\Form\HospedajeType;
use MainBundle\Entity\Favorito;
use MainBundle\Entity\Consulta;
use MainBundle\Entity\Hospedaje;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
    /**
    * @Route("/nuevoHospedaje", name="nuevoHospedaje")
    */
    public function nuevoHospedajeAction(){
        $em = $this->getDoctrine()->getManager();
        $tipos = $em->getRepository('MainBundle:TipoHospedaje')->findAllActives();
        return $this->render('MainBundle:Hospedaje:formNew.html.twig', array('tipos'=>$tipos));
    }

    /**
     * @Route("/hospSave", name="hospSave")
     */
    /*public function hospSaveAction(Request $request)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $titulo = $request->get('titulo');
            $existe = $em->getRepository($this->repositorio)->findOneByTitulo($titulo);
            if(!$existe) {
                $imagenes = $request->files->get('imagenes');
//                $imagen = $this->procesarImagenes($imagenes);
                $hospedaje = new Hospedaje();
                $hospedaje->setTitulo($titulo);
                $hospedaje->setImagenes($imagenes);
                $hospedaje->setDescripcion($request->get('descripcion'));
                $hospedaje->setLocalidad($request->get('localidad'));
                $hospedaje->setDireccion($request->get('direccion'));
                $hospedaje->setPrecio($request->get('precio'));
                $tipoHosp = $em->getRepository('MainBundle:TipoHospedaje')->findOneById($request->get('tipohospedaje'));
                $hospedaje->setTipohospedaje($tipoHosp);
                $session = $request->get('id');
                $usuario = $em->getRepository('MainBundle:Usuario')->findOneById($session);
                $date = new \DateTime("now");
                $hospedaje->setFechaPublicacion($date);
                $em = $this->getDoctrine()->getManager();
                $em->persist($hospedaje);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'El tipo de hospedaje '.$hospedaje->getTitulo().' fue creado correctamente.');
                return $this->redirect($this->generateUrl('misHospedajes'));
            }else{
                if($existe->getBorrado() == 0){
                    $this->get('session')->getFlashBag()->add('error', 'El Tipo de hospedaje ya existe.');
                    return $this->redirect($this->generateUrl('misHospedajes'));
                }else if($existe->getBorrado() == 1){
                    $existe->setBorrado(0);
                    $em->persist($existe);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('success', 'El tipo de hospedaje ' . $existe->getNombre() . ' fue creado correctamente.');
                    return $this->redirect($this->generateUrl('misHospedajes'));
                }
            }
        }catch (ORMException $e){
            print $e;
            $this->get('session')->getFlashBag()->add('error', 'Error al crear un nuevo tipo de hospedaje, intente nuevamente.');
            return $this->redirect($this->generateUrl('misHospedajes'));
        }
    }*/

    /*private function procesarImagenes($imagenes){
        $img = "";
        foreach ($imagenes['file'] as $imagen){
            $img = $imagenes['name'];
            $img = $img.';';
        }
        return $img;
    }*/

    /**
 * @Route("/marcarFav/{id}", name="marcarFav")
 * @param $id
 * @return \Symfony\Component\HttpFoundation\RedirectResponse
 */
    public function marcarFavoritoAction(Request $request, $id)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $hospedaje = $em->getRepository($this->repositorio)->findOneById($id);
            $favorito = new Favorito();
            $favorito->setHospedaje($hospedaje);
            $session = $request->getSession();
            $userId = $session->get('id');
            $usuario = $em->getRepository('MainBundle:Usuario')->findOneById($userId);
            $favorito->setUsuario($usuario);
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($favorito);
                $em->flush();
                $array = array('status'=> 200, 'msg'=>'Marcado con éxito.');
            }catch (ORMException $e){
                $array = array('status'=> 400, 'msg'=>'Error al mercar favorito.');
            }
        }catch (ORMException $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/desmarcarFav/{id}", name="desmarcarFav")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function desmarcarFavoritoAction(Request $request, $id)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $hospedaje = $em->getRepository($this->repositorio)->findOneById($id);
            $em = $this->getDoctrine()->getManager();
            $session = $request->getSession();
            $userId = $session->get('id');
            $usuario = $em->getRepository('MainBundle:Usuario')->findOneById($userId);
            $em = $this->getDoctrine()->getManager();
            $favorito = $em->getRepository('MainBundle:Favorito')->findOneBy(array('usuario'=>$usuario, 'hospedaje'=>$hospedaje));
            try{
                $em = $this->getDoctrine()->getManager();
                $em->remove($favorito);
                $em->flush();
                $array = array('status'=> 200, 'msg'=>'Desmarcado con éxito.');
            }catch (ORMException $e){
                $array = array('status'=> 400, 'msg'=>'Error al desmarcar favorito.');
            }
        }catch (ORMException $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/detalleHosp/{id}", name="detalleHosp")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function detalleHospAction($id)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $hospedaje = $em->getRepository($this->repositorio)->findDetalleHospedaje($id);
            $em = $this->getDoctrine()->getManager();
            $consultas = $em->getRepository('MainBundle:Consulta')->findAll();
            if(!$hospedaje){
                $array = array('status'=> 400, 'msg'=>'Hospedaje no encontrados');
            }else{
                return $this->render('MainBundle:Hospedaje:detalle.html.twig', array('hospedaje'=>$hospedaje, 'consultas'=>$consultas));
            }
        }catch (ORMException $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/hospPaginated", name="hospPaginated", defaults={"page" = 1})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function hospPaginatedAction($page)
    {
        try{
            $nextPage = $page + 1;
            $prevPage = $page - 1;
            $pageSize=10;
            $em = $this->getDoctrine()->getManager();
            $hospedajes = $em->getRepository('MainBundle:Hospedaje')->listarHospedajesPaginados($pageSize, $page);
            if(!$hospedajes){
                $array = array('status'=> 400, 'msg'=>'Hospedajes no encontrados');
            }else{
                $totalItems = count($hospedajes);
                $pagesCount = ceil($totalItems / $pageSize);
                return $this->render('MainBundle:Default:tablaHospedajes.html.twig', array('hospedajes'=>$hospedajes,
                    "pagesCount"=>$pagesCount, "next"=>$nextPage, "prev"=>$prevPage, "pagActual"=>$page, "total"=>$totalItems));
            }
        }catch (ORMException $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/searchHosp/{busqueda}", name="searchHosp", defaults={"page" = 1})
     * @param $busqueda
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function searchHospAction($busqueda,$page)
    {
        try{
            $nextPage = $page + 1;
            $prevPage = $page - 1;
            $pageSize=10;
            $em = $this->getDoctrine()->getManager();
            $hospedajes = $em->getRepository('MainBundle:Hospedaje')->buscarHospPaginated($busqueda, $pageSize, $page);
            if(!$hospedajes){
                $array = array('status'=> 400, 'msg'=>'Hospedajes no encontrados');
            }else{
                $totalItems = count($hospedajes);
                $pagesCount = ceil($totalItems / $pageSize);
                return $this->render('MainBundle:Default:tablaHospedajes.html.twig', array('hospedajes'=>$hospedajes,
                    "pagesCount"=>$pagesCount, "next"=>$nextPage, "prev"=>$prevPage, "pagActual"=>$page, "total"=>$totalItems));
            }
        }catch (ORMException $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/checkConsult", name="checkConsult")
     */
    public function checkConsultAction(Request $request)
    {
        $pregunta = $request->get('consulta');
        $idHospedaje = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $hospedaje = $em->getRepository('MainBundle:Hospedaje')->find($idHospedaje);
        $idUsuario = $request->getSession()->get('id');
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('MainBundle:Usuario')->find($idUsuario);

        $consulta = new Consulta();
        $consulta->setPregunta($pregunta);
        $consulta->setUsuario($usuario);
        $consulta->setHospedaje($hospedaje);
        $em = $this->getDoctrine()->getManager();
        $em->persist($consulta);
        $em->flush();;
        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * @Route("/responderConsulta", name="responderConsulta")
     */
    public function responderConsultaAction(Request $request)
    {
        $respuesta = $request->get('respuesta');
        $idConsulta = $request->get('idConsulta');
        $em = $this->getDoctrine()->getManager();
        $consulta = $em->getRepository('MainBundle:Consulta')->find($idConsulta);
        $consulta->setRespuesta($respuesta);
        $em->flush();;
        return $this->redirect($this->generateUrl('home'));
    }


}
