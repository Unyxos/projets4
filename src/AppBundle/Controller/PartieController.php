<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Partie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Request;

/**
 * Class PartieController
 * @package AppBundle\Controller
 * @Route("/partie")
 */
class PartieController extends Controller
{
    /**
     * @Route("/creer")
     * @Method("GET")
     */
    public function createPartie(){
        $createForm = $this->createForm('AppBundle\Form\PartieType');

        return $this->render('parties/creer-partie.html.twig', array(
            'create_form' => $createForm->createView(),
        ));
    }
}