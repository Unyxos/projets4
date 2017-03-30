<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Partie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PartieController
 * @package AppBundle\Controller
 * @Route("/partie")
 */
class PartieController extends Controller
{
    /**
     * Lists all party entities.
     *
     * @Route("/", name="admin_parties_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $parties = $em->getRepository('AppBundle:Partie')->findAll();
        return $this->render('parties/index.html.twig', array(
            'parties' => $parties,
        ));
    }

    /**
     * @Route("/creer")
     * @Method({"GET", "POST"})
     */
    public function createPartie(Request $request){
        $user = $this->getUser();
        $partie = new Partie();
        $partie->setJoueur1Id($user);
        $cartes = $this->getDoctrine()->getRepository('AppBundle:Cartes')->findAll();
        shuffle($cartes);

        $t = array();
        for ($i=0; $i<8; $i++){
            $t[] = $cartes[$i]->getId();
        }

        $partie->setMainJoueur1(json_encode($t));

        $t = array();
        for($i = 8; $i<16; $i++)
        {
            $t[] = $cartes[$i]->getId();
        }
        $partie->setMainJoueur2(json_encode($t));
        $t = array();
        for($i = 16; $i<count($cartes); $i++)
        {
            $t[] = $cartes[$i]->getId();
        }

        $partie->setPioche(json_encode($t));


        $createForm = $this->createForm('AppBundle\Form\PartieType');
        $createForm->handleRequest($request);

        if($createForm->isSubmitted() && $createForm->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($partie);
            $em->flush();
            return $this->redirectToRoute('admin_parties_index', array('id' => $partie->getId()));
        }

        return $this->render('parties/creer-partie.html.twig', array(
            'create_form' => $createForm->createView(),
        ));
    }

}