<?php

namespace MainBundle\Controller;

use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use MainBundle\Entity\TipoHospedaje;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home", defaults={"page" = 1})
     */
    public function indexAction($page)
    {
        $nextPage = $page + 1;
        $prevPage = $page - 1;
        $pageSize=10;
        $em = $this->getDoctrine()->getManager();
        $hospedajes = $em->getRepository('MainBundle:Hospedaje')->listarHospedajesPaginados($pageSize, $page);
        $totalItems = count($hospedajes);
        $pagesCount = ceil($totalItems / $pageSize);
        return $this->render('MainBundle:Default:index.html.twig', array('hospedajes'=>$hospedajes,
            "pagesCount"=>$pagesCount, "next"=>$nextPage, "prev"=>$prevPage, "pagActual"=>$page, "total"=>$totalItems));
    }
}
