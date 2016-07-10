<?php

namespace MainBundle\Controller;

use Doctrine\ORM\ORMException;
use MainBundle\Entity\Usuario;
use MainBundle\MainBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use MainBundle\Entity\TipoHospedaje;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction(Request $request)
    {
        return $this->render('MainBundle:Default:index.html.twig');
        /*$nextPage = $page + 1;
        $prevPage = $page - 1;
        $pageSize=10;
        $em = $this->getDoctrine()->getManager();
        $hospedajes = $em->getRepository('MainBundle:Hospedaje')->listarHospedajesPaginados($pageSize, $page);
        $totalItems = count($hospedajes);
        $pagesCount = ceil($totalItems / $pageSize);
        $em = $this->getDoctrine()->getManager();
        $tipos = $em->getRepository('MainBundle:TipoHospedaje')->findAllActives();
        if(self::checkSession($request)){
            $session = $request->getSession();
            $userId = $session->get('id');
            $em = $this->getDoctrine()->getManager();
            $favoritos = $em->getRepository('MainBundle:Favorito')->findBy(array('usuario'=>$userId));
            return $this->render('MainBundle:Default:index.html.twig', array('hospedajes'=>$hospedajes,
                "pagesCount"=>$pagesCount, "next"=>$nextPage, "prev"=>$prevPage, "pagActual"=>$page, "total"=>$totalItems, "favoritos"=>$favoritos,
                "tipos"=>$tipos));
        }else{
            return $this->render('MainBundle:Default:index.html.twig', array('hospedajes'=>$hospedajes,
                "pagesCount"=>$pagesCount, "next"=>$nextPage, "prev"=>$prevPage, "pagActual"=>$page, "total"=>$totalItems, "tipos"=>$tipos));
        }*/
    }
}
