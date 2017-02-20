<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class UserController extends Controller
{
    /**
     * @Route("/profil/{id}")
     * @Method("GET")
     */
    public function afficherProfilAction(User $user)
    {
        return $this->render('AppBundle:User:afficher_profil.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * @Route("mon-profil")
     */
    public function afficherMonProfilAction()
    {
        return $this->render('AppBundle:User:afficher_mon_profil.html.twig', array(
        ));
    }

    /**
     * @Route("modifier-profil")
     * @Method({"POST", "GET"})
     */
    public function modifierMonProfilAction(Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $userid = $user->getId();
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $userid));
        $form = $this->createForm('AppBundle\Form\UserType', $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

        }

        return $this->render('AppBundle:User:modifier_mon_profil.html.twig', array(
            'edit_form' => $form->createView()
        ));
    }

}
