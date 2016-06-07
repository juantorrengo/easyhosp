<?php

namespace MainBundle\Controller;

use Doctrine\ORM\ORMException;
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
     * @Route("/detalleHosp/{id}", name="detalleHosp")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function detalleHospAction($id)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $hospedaje = $em->getRepository($this->repositorio)->findDetalleHospedaje($id);
            if(!$hospedaje){
                $array = array('status'=> 400, 'msg'=>'Hospedaje no encontrados');
            }else{
                return $this->render('MainBundle:Hospedaje:detalle.html.twig', array('hospedaje'=>$hospedaje));
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

}
