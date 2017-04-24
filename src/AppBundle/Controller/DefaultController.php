<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
      
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }


    /**
     * @Route ("/classement", name="classement")
     */
    public function classement()
    {
        //on récupère tous les utilisateurs en bdd pour les afficher sur la page classement
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findBy(array(), array('points' => 'DESC'));

        return $this->render('default/classement.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * @Route ("/jeu", name="jeu")
     */
    public function jeu()
    {
        return $this->render('parties/exemple-plateau.html.twig');
    }

    /**
     * @Route ("/mail")
     */
    public function mailpreview(){
        return $this->render('mail/partie/creation_partie/mail_joueur_qui_invite.html.twig');
    }
}
