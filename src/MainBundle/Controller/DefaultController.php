<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use MainBundle\Form\TipoHospedajeType;
use MainBundle\Entity\TipoHospedaje;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        return $this->render('MainBundle:Default:index.html.twig');
    }

    /**
     * @Route("/tipos", name="tipos")
     */

    public function tiposAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipos = $em->getRepository('MainBundle:TipoHospedaje')->findAll();

        return $this->render('MainBundle:Default:tipos.html.twig', array('tipos' => $tipos));

    }

    /**
     * @Route("/tipos/edit/{id}", name="tipos_edit")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tipo = $em->getRepository('MainBundle:TipoHospedaje')->find($id);

        if (!$tipo)
        {
            throw $this->createNotFoundException('Tipo no encontrado');
        }

        $form = $this->createEditForm($tipo);   
        return $this->render('MainBundle:Default:edit.html.twig',array(
            'form' => $form->createView(),
            'tipo' => $tipo
        ));
    }

    private function createEditForm($entity)
    {
        $form = $this->createForm(TipoHospedajeType::class, $entity, array('action' => $this->generateUrl('tipo_update', array('id' => $entity->getId())), 'method' => 'POST'));

        return $form;
    }

    /**
     * @Route("/tipo/update/{id}", name="tipo_update")
     */
    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tipo = $em->getRepository('MainBundle:TipoHospedaje')->find($id);

        $form = $this->createEditForm($tipo);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $em->flush();

            $this->addFlash('mensaje', 'Tipo modificado');
            return $this->redirectToRoute('tipos');
        }
        return $this->render('MainBundle:Default:edit.html.twig', array('tipo' => $tipo, 'form' => $form->createView()));
    }
}
