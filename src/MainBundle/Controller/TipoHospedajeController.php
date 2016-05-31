<?php

namespace MainBundle\Controller;

use Doctrine\ORM\ORMException;
use MainBundle\Entity\TipoHospedaje;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Definition\Exception\Exception;

class TipoHospedajeController extends Controller
{
    private $repositorio = 'MainBundle:TipoHospedaje';

    /**
     * @Route("/tipoHospedajes", name="tipoHosp")
     */
    public function indexAction()
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $tipos = $em->getRepository($this->repositorio)->findAllActives();
            return $this->render('MainBundle:TipoHospedaje:index.html.twig', array('tipos'=>$tipos));
        }catch (Exception $e){
            return $this->generateUrl('admin');
        }
    }


    /**
     * @Route("/tipos/new", name="tiposNew")
     */
    public function tiposNewAction()
    {
        return $this->render('MainBundle:TipoHospedaje:formNew.html.twig');
    }

    /**
     * @Route("/tipos/edit/{id}", name="tiposEdit")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function tiposEditAction($id)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $tipo = $em->getRepository($this->repositorio)->findOneById($id);
            if(!$tipo){
                $array = array('status'=> 400, 'msg'=>'Tipo no encontrado');
            }else{
                return $this->render('MainBundle:TipoHospedaje:formEdit.html.twig', array('tipo'=>$tipo));
            }
        }catch (Exception $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/tiposMsjDelete/{id}", name="tiposMsjDelete")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function tiposMsjDeleteAction($id)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $tipo = $em->getRepository($this->repositorio)->findOneById($id);
            if(!$tipo){
                $array = array('status'=> 400, 'msg'=>'Tipo no encontrado');
            }else{
                return $this->render('MainBundle:TipoHospedaje:msjDelete.html.twig', array('tipo'=>$tipo));
            }
        }catch (Exception $e){
            $array = array('status'=> 400, 'msg'=>'Error inesperado, intente nuevamente');
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/tipoHospSave", name="tipoHospSave")
     */
    public function tipoHospSaveAction(Request $request)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $nombre = $request->get('nombre');
            $existe = $em->getRepository($this->repositorio)->findOneByNombre($nombre);
            if(!$existe) {
                $tipo = new TipoHospedaje();
                $tipo->setNombre($request->get('nombre'));
                $tipo->setBorrado(0);
                $em = $this->getDoctrine()->getManager();
                $em->persist($tipo);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'El tipo de hospedaje '.$tipo->getNombre().' fue creado correctamente.');
                return $this->redirect($this->generateUrl('tipoHosp'));
            }else{
                if($existe->getBorrado() == 0){
                    $this->get('session')->getFlashBag()->add('error', 'El Tipo de hospedaje ya existe.');
                    return $this->redirect($this->generateUrl('tipoHosp'));
                }else if($existe->getBorrado() == 1){
                    $existe->setBorrado(0);
                    $em->persist($existe);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('success', 'El tipo de hospedaje ' . $existe->getNombre() . ' fue creado correctamente.');
                    return $this->redirect($this->generateUrl('tipoHosp'));
                }
            }
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'Error al crear un nuevo tipo de hospedaje, intente nuevamente.');
            return $this->redirect($this->generateUrl('tipoHosp'));
        }
    }

    /**
     * @Route("/tipoHospEditSave", name="tipoHospEditSave")
     */
    public function tipoHospEditSaveAction(Request $request)
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
     * @Route("/tipoHospDelete", name="tipoHospDelete")
     */
    public function tipoHospDeleteAction(Request $request)
    {
        try{
            $idTipoDelete = $request->get('idTipo');
            $em = $this->getDoctrine()->getManager();
            $tieneHospedajes = $em->getRepository($this->repositorio)->findHospedajesForTipo($idTipoDelete);
            $em = $this->getDoctrine()->getManager();
            $tipoDelete = $em->getRepository($this->repositorio)->findOneById($idTipoDelete);
            if(!$tieneHospedajes){
                $em->remove($tipoDelete);
                $em->flush();
            }else{
                $tipoDelete->setBorrado(1);
                $em->persist($tipoDelete);
                $em->flush();
            }
            $this->get('session')->getFlashBag()->add('success', 'El tipo de hospedaje '.$tipoDelete->getNombre().' fue eliminado correctamente.');
            return $this->redirect($this->generateUrl('tipoHosp'));
        }catch (ORMException $e){
            $this->get('session')->getFlashBag()->add('error', 'Error al eliminar el tipo de hospedaje, intente nuevamente.');
            return $this->redirect($this->generateUrl('tipoHosp'));
        }
    }
}
