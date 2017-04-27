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
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/contact"), name="contact")
     */
    public function contact(){
        return $this->render('default/contact.html.twig');
    }

    /**
     * @param Request $request
     * @Route("/contact-envoyer", name="envoi_contact")
     */
    public function contactEnvoi(Request $request){
        $formulaire = $request->request->all();
        $message = \Swift_Message::newInstance()
            ->setSubject('Nouvelle demande de contact !')
            ->setFrom('frenchfoodcontest@corentincloss.fr')
            ->setTo('corentin.closs@gmail.com')
            ->setBody(
                $this->renderView(
                    'mail/form-contact.html.twig',
                    array(
                        'nom' => $formulaire['nom'],
                        'prenom' => $formulaire['prenom'],
                        'email' => $formulaire['email'],
                        'message' => $formulaire['message'],
                    )
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);

        $this->get('session')->getFlashBag()->add('error',
            'Votre message a bien été envoyé ! Vous recevrez une réponse au plus vite !'
        );

        //on envoi un mail à un administrateur
        return $this->redirectToRoute('app_default_contact');
    }

    /**
     * @param Request $request
     * @Route("/concours-envoyer", name="envoi_concours")
     */
    public function concoursEnvoi(Request $request){
        $formulaire = $request->request->all();
        $message = \Swift_Message::newInstance()
            ->setSubject('Nouvelle recette pour le concours !')
            ->setFrom('frenchfoodcontest@corentincloss.fr')
            ->setTo('corentin.closs@gmail.com')
            ->setBody(
                $this->renderView(
                    'mail/form-concours.html.twig',
                    array(
                        'nom' => $formulaire['nom'],
                        'prenom' => $formulaire['prenom'],
                        'mail' => $formulaire['mail'],
                        'recette' => $formulaire['recette'],
                    )
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);

        $this->get('session')->getFlashBag()->add('error',
            'Votre recette a bien été envoyée ! Surveillez notre magazine pour peut être la découvrir ;)'
        );

        //on envoi un mail à un administrateur
        return $this->redirectToRoute('concours');
    }

    /**
     * @Route("/concours", name="concours")
     */
    public function concours(){
        return $this->render('default/concours.html.twig');
    }

    /**
     * @Route("magazine/", name="magazine")
     */
    public function magazine(){
        return $this->render('default/magazine.html.twig');
    }
}
