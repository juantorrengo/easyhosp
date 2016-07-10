<?php

namespace MainBundle\Controller;

use Doctrine\ORM\ORMException;
use MainBundle\Entity\Favorito;
use MainBundle\Entity\Hospedaje;
use MainBundle\Entity\Consulta;
use MainBundle\Entity\TipoHospedaje;
//use MainBundle\Form\HospType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class HospedajeController extends Controller
{
    private $repositorio = 'MainBundle:Hospedaje';

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
     * @Route("/nuevoHospedaje", name="nuevoHospedaje", options={"expose"=true})
     */
    public function nuevoHospedajeAction(){
        $em = $this->getDoctrine()->getManager();
        $tipos = $em->getRepository('MainBundle:TipoHospedaje')->findAllActives();
        return $this->render('MainBundle:Hospedaje:formNew.html.twig', array('tipos'=>$tipos));
    }

    /**
     * @Route("/hospSave", name="hospSave", options={"expose"=true})
    */
    public function hospSaveAction(Request $request){
        try{
            $idUsuario = $request->getSession()->get('id');
            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository('MainBundle:Usuario')->find($idUsuario);

            $idTipo = $request->get('tipohospedaje');
            $em = $this->getDoctrine()->getManager();
            $tipo = $em->getRepository('MainBundle:TipoHospedaje')->find($idTipo);

            $hospedaje = new Hospedaje();
            $hospedaje->setTitulo($request->get('titulo'));
            $hospedaje->setDescripcion($request->get('descripcion'));
            $hospedaje->setDireccion($request->get('direccion'));
            $hospedaje->setLocalidad($request->get('localidad'));
            $hospedaje->setPrecio($request->get('precio'));
            $hospedaje->setCapacidad($request->get('capacidad'));
            $hospedaje->setBorrado(0);
            $hospedaje->setUsuario($usuario);
            $hospedaje->setTipohospedaje($tipo);
            $em = $this->getDoctrine()->getManager();
            $em->persist($hospedaje);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'El Hospedaje fue creado correctamente.');
            return $this->redirect($this->generateUrl('misHospedajes'));
        }
        catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'Error inesperado, intente nuevamente.');
            return $this->render('MainBundle:Admin:index.html.twig');
        }
    }
    /**
     * @Route("/checkDisp/{from}/{to}/{id}", name="checkDisp", options={"expose"=true})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function checkDispAction(Request $request, $from, $to, $id){
        $em = $this->getDoctrine()->getManager();
        $ocupada = $em->getRepository('MainBundle:Reserva')->findDisponibilidad($from, $to, $id);
        if($ocupada == null){
            $array = array('status'=> 200, 'msg'=>'Disponible!');
        }else{
            $array = array('status'=> 400, 'msg'=>'No disponible para las fechas seleccionadas.');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }



    /**
 * @Route("/marcarFav/{id}", name="marcarFav", options={"expose"=true})
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
     * @Route("/desmarcarFav/{id}", name="desmarcarFav", options={"expose"=true})
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
     * @Route("/detalleHosp/{id}/{desde}/{hasta}",options={"expose"=true}, name="detalleHosp",
     *     defaults={"desde" = 1, "hasta" = 1})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */

    public function detalleHospAction($id, $desde, $hasta)
    {
        try{

            $em = $this->getDoctrine()->getManager();
            $hospedaje = $em->getRepository($this->repositorio)->findDetalleHospedaje($id);
            $monto = $this->calcularMontoTotal($hospedaje["precio"],$hasta, $desde);
            $em = $this->getDoctrine()->getManager();
            $consultas = $em->getRepository('MainBundle:Consulta')->findBy(array('hospedaje'=>$id));
            if(!$hospedaje){
                $this->get('session')->getFlashBag()->add('error', 'Error al recuperar el detalle del hospedaje, intente nuevamente.');
                return $this->redirect($this->generateUrl('home'));
            }else{
                return $this->render('MainBundle:Hospedaje:detalle.html.twig', array('hospedaje'=>$hospedaje, 'consultas'=>$consultas, 'desde'=>$desde, 'hasta'=>$hasta,
                    'monto'=>$monto));
            }
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'Error inesperado, por favor intente nuevamente');
            return $this->redirect($this->generateUrl('home'));
        }
    }

    private function calcularMontoTotal($precio,$fecha1,$fecha2){
        $segundos = strtotime($fecha1) - strtotime($fecha2);
        $dias = intval($segundos/60/60/24);
        $total = $precio * $dias;
        return $total;
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
     * @Route("/searchHosp", name="searchHosp",options={"expose"=true})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function searchHospAction(Request $request)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $desde = $request->get('desde');
            $hasta = $request->get('hasta');
            $hospedajes = $em->getRepository('MainBundle:Reserva')->findDisponibilidad($desde, $hasta);
            if(!$hospedajes){
                $array = array('status'=> 400, 'msg'=>'Hospedajes no encontrados');
            }else{
                if(self::checkSession($request)) {
                    $session = $request->getSession();
                    $userId = $session->get('id');
                    $em = $this->getDoctrine()->getManager();
                    $favoritos = $em->getRepository('MainBundle:Favorito')->findBy(array('usuario' => $userId));
                    return $this->render('MainBundle:Default:tablaHospedajes.html.twig', array('hospedajes' => $hospedajes, 'favoritos' => $favoritos));
                }else{
                    return $this->render('MainBundle:Default:tablaHospedajes.html.twig', array('hospedajes'=>$hospedajes));
                }
            }
        }catch (Exception $e){
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

    /**
     * @Route("/hospedajeMsjDelete/{id}", name="hospedajeMsjDelete")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function hospedajeMsjDeleteAction($id)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $hospedaje = $em->getRepository($this->repositorio)->findOneById($id);
            if(!$hospedaje){
                $array = array('status'=> 400, 'msg'=>'Hospedaje no encontrado');
            }else{
                return $this->render('MainBundle:Hospedaje:msjDelete.html.twig', array('hospedaje'=>$hospedaje));
            }
        }catch (Exception $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/hospedajeDelete", name="hospedajeDelete")
     */
    public function hospedajeDeleteAction(Request $request)
    {
        try {
            $idHospedajeDelete = $request->get('idHospedaje');
            $em = $this->getDoctrine()->getManager();
            $tieneReservas = $em->getRepository('MainBundle:Reserva')->findOneByReserva($idHospedajeDelete);
            $em = $this->getDoctrine()->getManager();
            $hospedajeDelete = $em->getRepository($this->repositorio)->findOneById($idHospedajeDelete);
            if(!$tieneReservas){
                $hospedajeDelete->setBorrado(1);
                $em->persist($hospedajeDelete);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'El hospedaje '.$hospedajeDelete->gettitulo().' fue borrado.');
            }else{
                $hospedajeDelete->setBorrado(1);
                $em->persist($hospedajeDelete);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'El hospedaje '.$hospedajeDelete->gettitulo().' fue archivado ya que tiene hospedajes asociados.');
            }
            return $this->redirect($this->generateUrl('misHospedajes'));
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'Error al eliminar el hospedaje, intente nuevamente.');
            return $this->redirect($this->generateUrl('misHospedajes'));
        }
    }

    /**
     * @Route("/hospedajeEdit/{id}", name="hospedajeEdit")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function hospedajeEditAction($id)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $tipos = $em->getRepository('MainBundle:TipoHospedaje')->findAllActives();

            $em = $this->getDoctrine()->getManager();
            $hospedaje = $em->getRepository($this->repositorio)->findOneById($id);
            if(!$hospedaje){
                $array = array('status'=> 400, 'msg'=>'Hospedaje no encontrado');
            }else{
                return $this->render('MainBundle:Hospedaje:formEdit.html.twig', array('hospedaje'=>$hospedaje, 'tipos'=>$tipos));
            }
        }catch (Exception $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/hospEditSave", name="hospEditSave")
     */
    public function hospEditSaveAction(Request $request)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $tipo = $em->getRepository($this->repositorio)->findOneById($request->get('idTipo'));
            $tipo->setNombre($request->get('nombre'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipo);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'El tipo de hospedaje '.$tipo->getNombre().' fue editado correctamente.');
            return $this->redirect($this->generateUrl('tipoHosp'));
        }catch (Exception $e){
            $this->get('session')->getFlashBag()->add('error', 'Error al edtar tipo de hospedaje, intente nuevamente.');
            return $this->redirect($this->generateUrl('tipoHosp'));
        }
    }

    /**
     * @Route("/hospedajeMsjHabilitar/{id}", name="hospedajeMsjHabilitar")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function hospedajeMsjHabilitarAction($id)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $hospedaje = $em->getRepository($this->repositorio)->findOneById($id);
            if(!$hospedaje){
                $array = array('status'=> 400, 'msg'=>'Hospedaje no encontrado');
            }else{
                return $this->render('MainBundle:Hospedaje:msjHabilitar.html.twig', array('hospedaje'=>$hospedaje));
            }
        }catch (Exception $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/hospedajeHabilitar", name="hospedajeHabilitar")
     */
    public function hospedajeHabilitarAction(Request $request)
    {
        try{
            $idHospedajeHabilitar = $request->get('idHospedaje');
            $em = $this->getDoctrine()->getManager();
            $hospedajeHabilitar = $em->getRepository($this->repositorio)->findOneById($idHospedajeHabilitar);
            $hospedajeHabilitar->setBorrado(0);
            $em->persist($hospedajeHabilitar);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'El hospedaje '.$hospedajeHabilitar->gettitulo().' fue habilitado.');
            return $this->redirect($this->generateUrl('misHospedajes'));
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'Error al eliminar el hospedaje, intente nuevamente.');
            return $this->redirect($this->generateUrl('misHospedajes'));
        }
    }
}
