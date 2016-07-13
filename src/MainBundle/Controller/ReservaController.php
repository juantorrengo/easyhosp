<?php

namespace MainBundle\Controller;

use Doctrine\ORM\ORMException;
use MainBundle\Entity\Calificacion;
use MainBundle\Entity\Hospedaje;
use MainBundle\Entity\Reserva;
use MainBundle\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class ReservaController extends Controller
{
    private $repositorio = 'MainBundle:Reserva';
    
    /**
     * @Route("/reservar", name="reservarHosp")
     */
    public function reservarAction(Request $request)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('MainBundle:Usuario')->findOneById($request->get('user'));
            $em = $this->getDoctrine()->getManager();
            $hospedaje = $em->getRepository('MainBundle:Hospedaje')->findOneById($request->get('hospID'));
            $em = $this->getDoctrine()->getManager();
            $reserva = new Reserva();
            $reserva->setUsuario($user);
            $reserva->setHospedaje($hospedaje);
            $reserva->setFechaInicio(new \DateTime($request->get('fechaDesde')));
            $reserva->setFechaFin(new \DateTime($request->get('fechaHasta')));
            $reserva->setEstado(0);
            $em->persist($reserva);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'La reserva se ha hecho correctamente.');
            return $this->redirect($this->generateUrl('home'));
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'Error inesperado, intente nuevamente.');
            return $this->redirect($this->generateUrl('home'));
        }
    }

    /**
     * @Route("/msgConRes/{id}", name="msgConRes", options={"expose"=true})
     */
    public function msgConResAction(Request $request, $id)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $datosReserva = $em->getRepository('MainBundle:Reserva')->findDatosReserva($id);
            return $this->render('MainBundle:Reservas:msjConfirmar.html.twig', array('r'=>$datosReserva));
        }catch (Exception $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/msgRechRes/{id}", name="msgRechRes", options={"expose"=true})
     */
    public function msgRechResAction(Request $request, $id)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $datosReserva = $em->getRepository('MainBundle:Reserva')->findDatosReserva($id);
            return $this->render('MainBundle:Reservas:msjRechazar.html.twig', array('r'=>$datosReserva));
        }catch (Exception $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/calificar/{id}", name="formCalificar", options={"expose"=true})
     */
    public function formCalificarAction(Request $request, $id)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $datos = $em->getRepository('MainBundle:Reserva')->findDatosCalificarRes($id);
            return $this->render('MainBundle:Reservas:formCalificar.html.twig', array('r'=>$datos));
        }catch (Exception $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/calificarReserva", name="calificarReserva")
     */
    public function calificarReservaAction(Request $request)
    {
        try{
            $resId = $request->get('idRes');
            $userId = $request->get('userId');
            $hospId = $request->get('hospId');
            $em = $this->getDoctrine()->getManager();
            $hospedaje = $em->getRepository('MainBundle:Hospedaje')->findOneById($hospId);
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('MainBundle:Usuario')->findOneById($userId);
            $calificacion = new Calificacion();
            $calificacion->setHospedaje($hospedaje);
            $calificacion->setUsuario($user);
            $calificacion->setPuntuacion($request->get('puntaje'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($calificacion);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'La calificación fue realizada correctamente.');
            return $this->redirect($this->generateUrl('misReservas'));
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'La calificación no se pudo realizar.');
            return $this->redirect($this->generateUrl('misReservas'));
        }
    }

    /**
     * @Route("/rechazarReserva", name="rechazarReserva")
     */
    public function rechazarReservaAction(Request $request)
    {
        try{
            $id = $request->get('idRes');
            $em = $this->getDoctrine()->getManager();
            $reserva = $em->getRepository('MainBundle:Reserva')->findOneById($id);
            $reserva->setEstado(2);
            $em = $this->getDoctrine()->getManager();
            $em->persist($reserva);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'La reserva fue rechazada correctamente.');
            return $this->redirect($this->generateUrl('misReservas'));
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'La reserva no pudo ser rechazada.');
            return $this->redirect($this->generateUrl('misReservas'));
        }
    }

    /**
     * @Route("/confirmarReserva", name="confirmarReserva")
     */
    public function confirmarReservaAction(Request $request)
    {
        try{
            $id = $request->get('idRes');
            $em = $this->getDoctrine()->getManager();
            $reserva = $em->getRepository('MainBundle:Reserva')->findOneById($id);
            $reserva->setEstado(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($reserva);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'La reserva fue confirmada correctamente.');
            return $this->redirect($this->generateUrl('misReservas'));
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'La reserva no pudo ser confirmada.');
            return $this->redirect($this->generateUrl('misReservas'));
        }
    }
    

    /**
     * @Route("/resSinConf", name="resSinConf", options={"expose"=true})
     */
    public function resSinConfAction(Request $request)
    {
        try{
            $userId = $request->getSession()->get('id');
            $em = $this->getDoctrine()->getManager();
            $resevas = $em->getRepository('MainBundle:Reserva')->findResSinConf($userId);
            return $this->render('MainBundle:Reservas:tablaResSinConf.html.twig', array('reservas'=>$resevas));
        }catch (Exception $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/misReservasAjax", name="misReservasAjax", options={"expose"=true})
     */
    public function misReservasAjaxAction(Request $request)
    {
        try{
            $userId = $request->getSession()->get('id');
            $em = $this->getDoctrine()->getManager();
            $resevas = $em->getRepository('MainBundle:Reserva')->findMisReservas($userId);
            return $this->render('MainBundle:Reservas:tablaHospedajes.html.twig', array('reservas'=>$resevas));
        }catch (Exception $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/misReservas", name="misReservas")
     */
    public function misReservasAction(Request $request)
    {
        try{
            $userId = $request->getSession()->get('id');
            $em = $this->getDoctrine()->getManager();
            $resevas = $em->getRepository('MainBundle:Reserva')->findMisReservas($userId);
            return $this->render('MainBundle:Reservas:reservas.html.twig', array('reservas'=>$resevas));
        }catch (Exception $e){
            $this->get('session')->getFlashBag()->add('error', 'Error inesperado, intente nuevamente.');
            return $this->redirect($this->generateUrl('home'));
        }
    }

    /**
     * @Route("/resFinalizadas", name="resFinalizadas", options={"expose"=true})
     */
    public function resFinalizadasAction(Request $request)
    {
        try{
            $userId = $request->getSession()->get('id');
            $em = $this->getDoctrine()->getManager();
            $resevas = $em->getRepository('MainBundle:Reserva')->findResFinalizadas($userId);
            return $this->render('MainBundle:Reservas:tablaResFinalizadas.html.twig', array('reservas'=>$resevas));
        }catch (Exception $e){
            $this->get('session')->getFlashBag()->add('error', 'Error inesperado, intente nuevamente.');
            return $this->redirect($this->generateUrl('home'));
        }
    }

    /**
     * @Route("/detalleReserva/{id}", options={"expose"=true}, name="detalleReserva")
     */
    public function detalleReservaAction(Request $request, $id)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $reseva = $em->getRepository('MainBundle:Reserva')->findDetalleReserva($id);
            return $this->render('MainBundle:Reservas:detalle.html.twig', array('reserva'=>$reseva));
        }catch (Exception $e){
            $this->get('session')->getFlashBag()->add('error', 'Error inesperado, intente nuevamente.');
            return $this->redirect($this->generateUrl('home'));
        }
    }

}
