<?php

namespace MainBundle\Controller;

use Doctrine\ORM\ORMException;
use MainBundle\Entity\Reserva;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;

class ReservaController extends Controller
{
    private $repositorio = 'MainBundle:Reserva';
    
    /**
     * @Route("/reservar", name="reservar")
     */
    public function reservarAction(Request $request)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('MainBundle:Usuario')->findOneById($request->get('user'));
            $em = $this->getDoctrine()->getManager();
            $hospedaje = $em->getRepository('MainBundle:Hospedaje')->findOneById($request->get('hospId'));
            $em = $this->getDoctrine()->getManager();
            $reserva = new Reserva();
            $reserva->setUsuario($user);
            $reserva->setHospedaje($hospedaje);
            $reserva->setFechaInicio(new \DateTime($request->get('desde')));
            $reserva->setFechaFin(new \DateTime($request->get('hasta')));
            $reserva->setMonto($request->get('monto'));
            $reserva->setConfirmada(0);
            $em->persist($reserva);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'La reserva se ha hecho correctamente.');
            return $this->redirect($this->generateUrl('home'));
        }catch (ORMException $e){
            $this->get('error')->getFlashBag()->add('error', 'Error inesperado, intente nuevamente.');
            return $this->redirect($this->generateUrl('home'));
        }
    }

}
