<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cartes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Carte controller.
 *
 * @Route("cartes")
 */
class CartesController extends Controller
{
    /**
     * Lists all carte entities.
     *
     * @Route("/", name="cartes_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cartes = $em->getRepository('AppBundle:Cartes')->findAll();

        return $this->render('cartes/index.html.twig', array(
            'cartes' => $cartes,
        ));
    }

    /**
     * Creates a new carte entity.
     *
     * @Route("/new", name="cartes_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $carte = new Cartes();
        $form = $this->createForm('AppBundle\Form\CartesType', $carte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($carte);
            $em->flush($carte);

            return $this->redirectToRoute('cartes_show', array('id' => $carte->getId()));
        }

        return $this->render('cartes/new.html.twig', array(
            'carte' => $carte,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a carte entity.
     *
     * @Route("/{id}", name="cartes_show")
     * @Method("GET")
     */
    public function showAction(Cartes $carte)
    {
        $deleteForm = $this->createDeleteForm($carte);

        return $this->render('cartes/show.html.twig', array(
            'carte' => $carte,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing carte entity.
     *
     * @Route("/{id}/edit", name="cartes_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Cartes $carte)
    {
        $deleteForm = $this->createDeleteForm($carte);
        $editForm = $this->createForm('AppBundle\Form\CartesType', $carte);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cartes_edit', array('id' => $carte->getId()));
        }

        return $this->render('cartes/edit.html.twig', array(
            'carte' => $carte,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a carte entity.
     *
     * @Route("/{id}", name="cartes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Cartes $carte)
    {
        $form = $this->createDeleteForm($carte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($carte);
            $em->flush($carte);
        }

        return $this->redirectToRoute('cartes_index');
    }

    /**
     * Creates a form to delete a carte entity.
     *
     * @param Cartes $carte The carte entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cartes $carte)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cartes_delete', array('id' => $carte->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
