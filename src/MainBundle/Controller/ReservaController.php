<?php

namespace MainBundle\Controller;

use Doctrine\ORM\ORMException;
use MainBundle\Entity\Reserva;
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
            $reserva->setMonto($request->get('monto'));
            $reserva->setConfirmada(0);
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
     * @Route("/misReservas", name="misReservas")
     */
    public function misReservasAction(Request $request)
    {
        try{
            $hoy = new DateTime();
            $userId = $request->getSession()->get('id');
            $em = $this->getDoctrine()->getManager();
            $resevas = $em->getRepository('MainBundle:Reserva')->findMisReservas($userId);
            return $this->render('MainBundle:Reservas:reservas.html.twig', array('reservas'=>$resevas, 'hoy'=>$hoy));
        }catch (Exception $e){
            $this->get('session')->getFlashBag()->add('error', 'Error inesperado, intente nuevamente.');
            return $this->redirect($this->generateUrl('home'));
        }
    }

}
