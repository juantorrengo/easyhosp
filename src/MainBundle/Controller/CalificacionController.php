<?php

namespace MainBundle\Controller;

use Doctrine\ORM\ORMException;
use MainBundle\Entity\Calificacion;
use MainBundle\Entity\CalificacionHuesped;
use MainBundle\Entity\Hospedaje;
use MainBundle\Entity\Reserva;
use MainBundle\Entity\Usuario;
use MainBundle\MainBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class CalificacionController extends Controller
{
    private $repositorio = 'MainBundle:Calificacion';
    
    /**
     * @Route("/misCalificaciones", name="misCalificaciones")
     */
    public function misCalificacionesAction(Request $request)
    {
        try{
            $user = $request->getSession()->get('id');
            $em = $this->getDoctrine()->getManager();
            $calificaciones = $em->getRepository('MainBundle:CalificacionHuesped')->findRecibidasAsGuest($user);
            $prom = $this->calcularPromedio($calificaciones);
            return $this->render('MainBundle:Calificaciones:calificaciones.html.twig', array('calificaciones'=>$calificaciones, 'promedio'=>$prom));
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'Error inesperado, intente nuevamente.');
            return $this->redirect($this->generateUrl('home'));
        }
    }

    /**
     * @Route("/misCalificacionesmisAjax", name="misCalificacionesAjax", options={"expose"=true})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function misCalificacionesAjaxAction(Request $request)
    {
        try{
            $user = $request->getSession()->get('id');
            $em = $this->getDoctrine()->getManager();
            $calificaciones = $em->getRepository('MainBundle:CalificacionHuesped')->findRecibidasAsGuest($user);
            $prom = $this->calcularPromedio($calificaciones);
            return $this->render('MainBundle:Calificaciones:tablaCalificacionesRecibidas.html.twig', array('calificaciones'=>$calificaciones, 'promedio'=>$prom));
        }catch (ORMException $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/dadasAHuespedes", name="dadasAHuespedes", options={"expose"=true})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function dadasAHuespedesAction(Request $request)
    {
        try{
            $user = $request->getSession()->get('id');
            $em = $this->getDoctrine()->getManager();
            $calificaciones = $em->getRepository('MainBundle:CalificacionHuesped')->findOtorgadasToGuest($user);
            $prom = $this->calcularPromedio($calificaciones);
            return $this->render('MainBundle:Calificaciones:tablaCalificacionesOtorgadasHuespedes.html.twig', array('calificaciones'=>$calificaciones, 'promedio'=>$prom));
        }catch (ORMException $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/dadasAHospedajes", name="dadasAHospedajes", options={"expose"=true})
     */
    public function dadasAHospedajesAction(Request $request)
    {
        try{
            $user = $request->getSession()->get('id');
            $em = $this->getDoctrine()->getManager();
            $calificaciones = $em->getRepository('MainBundle:CalificacionHuesped')->findOtorgadasToHosp($user);
            $prom = $this->calcularPromedio($calificaciones);
            return $this->render('MainBundle:Calificaciones:tablaCalificacionesOtorgadasHospedajes.html.twig', array('calificaciones'=>$calificaciones, 'promedio'=>$prom));
        }catch (ORMException $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/recibidasHospedajes", name="recibidasHospedajes", options={"expose"=true})
     */
    public function califRecibidasHospAction(Request $request)
    {
        try{
            $user = $request->getSession()->get('id');
            $em = $this->getDoctrine()->getManager();
            $calificaciones = $em->getRepository('MainBundle:CalificacionHuesped')->findRecibidasAsOwner($user);
            $prom = $this->calcularPromedio($calificaciones);
            return $this->render('MainBundle:Calificaciones:tablaCalificacionesRecibidasAsOwner.html.twig', array('calificaciones'=>$calificaciones, 'promedio'=>$prom));
        }catch (ORMException $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    private function calcularPromedio($array){
        $cant = count($array);
        $promedio = "";
        if($cant>0){
            $valor = 0;
            foreach ($array as $item){
                $valor = $valor + $item['puntaje'];
            }
            $promedio = ($valor/$cant);
        }

        return $promedio;
    }

}
