<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Partie;
use AppBundle\Entity\User;
use AppBundle\Entity\Cartes;
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
     * @Route("/", name="parties_index")
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
        $userid = $user->getId();
        $partie = new Partie();

        $createForm = $this->createForm('AppBundle\Form\PartieType', $partie);
        $createForm->handleRequest($request);

        if($createForm->isSubmitted() && $createForm->isValid()){
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

            $t = array(
                'aperitif' => array(),
                'entree' => array(),
                'plat' => array(),
                'laitage' => array(),
                'dessert' => array(),
            );

            $partie->setPlateauJoueur1(json_encode($t));
            $partie->setPlateauJoueur2(json_encode($t));

            $partie->setDefausse(json_encode($t));

            $partie->setPartieTourJoueurId($this->getUser()->getId());

            $partie->setCompteurActionTour(0);

            $em = $this->getDoctrine()->getManager();
            $em->persist($partie);
            $em->flush();

            $message = \Swift_Message::newInstance()
                ->setSubject('Invitation à une partie !')
                ->setFrom('no-reply@dev.corentincloss.fr')
                ->setTo($partie->getJoueur2Id()->getEmail())
                ->setBody(
                    $this->renderView(
                        'mail/partie/creation_partie/mail_joueur_invite.html.twig',
                        array(
                            'joueur1' => $partie->getJoueur1Id()->getUsername(),
                            'joueur2' => $partie->getJoueur2Id()->getUsername(),
                            'id' => $partie->getId()
                        )
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);

            $message2 = \Swift_Message::newInstance()
                ->setSubject('Invitation à une partie !')
                ->setFrom('no-reply@dev.corentincloss.fr')
                ->setTo($partie->getJoueur1Id()->getEmail())
                ->setBody(
                    $this->renderView(
                        'mail/partie/creation_partie/mail_joueur_qui_invite.html.twig',
                        array(
                            'joueur1' => $partie->getJoueur1Id()->getUsername(),
                            'joueur2' => $partie->getJoueur2Id()->getUsername(),
                            'id' => $partie->getId()
                        )
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message2);

            return $this->redirectToRoute('parties_index', array('id' => $partie->getId()));
        }

        return $this->render('parties/creer-partie.html.twig', array(
            'create_form' => $createForm->createView(),
        ));
    }

    /**
     * @param Parties $id
     * @Route("/afficher/{id}", name="afficher_partie")
     * @Method("GET")
     */
    public function afficherPartie(Partie $id){
        $user = $this->getUser();
        $userid = $this->getUser()->getId();

        //var_dump($user->getEmail());

        if ($userid == $id->getJoueur1Id()->getId() || $userid == $id->getJoueur2Id()->getId()){
            $cartes = $this->getDoctrine()->getRepository('AppBundle:Cartes')->getAll();

            $plateau['mainJ1'] = json_decode($id->getMainJoueur1());
            $plateau['mainJ2'] = json_decode($id->getMainJoueur2());
            $plateau['pioche'] = json_decode($id->getPioche());
            $plateau['plateauJ1'] = json_decode($id->getPlateauJoueur1());
            $plateau['plateauJ2'] = json_decode($id->getPlateauJoueur2());
            $plateau['defausse'] = json_decode($id->getDefausse());

            return $this->render('parties/affichage-partie.html.twig',
                [
                    'cartes' => $cartes,
                    'partie' => $id,
                    'user' => $user,
                    'plateau' => $plateau,
                ]
            );
        }
        return $this->render('parties/erreurs/non-joueur.html.twig');
    }

    public function getCarte($id){
        $em = $this->getDoctrine()->getManager();
        $carte = $em->getRepository('AppBundle:Cartes')->findOneById($id);
        return $carte;
    }

    /**
     * @Route("/poser/{partie}", name="poser_carte")
     */
    public function poserCarte(Request $request, Partie $partie){
        $cartePosee = $request->request->all();
        $cartePoseeTrait = $cartePosee['carte_id'];

        $em = $this->getDoctrine()->getManager();
        $carte = $em->getRepository('AppBundle:Cartes')->findOneById($cartePoseeTrait);

        $tourde = $partie->getPartieTourJoueurId();

        $joueur1 = $partie->getJoueur1Id()->getId();

        $joueur2 = $partie->getJoueur2Id()->getId();

        if ($tourde == $joueur1) {
            $mainJ1 = json_decode($partie->getMainJoueur1());

            //On vérifie que la carte est dans la main du joueur
            if (in_array($cartePoseeTrait, $mainJ1)) {
                $plateauJ1 = json_decode($partie->getPlateauJoueur1(), true);
                if ($carte->getExtra() == 1) {
                    //si la carte est une carte extra
                    //on vérifie que la dernière carte posée est une carte extra
                    if(empty($plateauJ1[$carte->getCategorie()])){
                        //On ajoute la carte
                        array_push($plateauJ1[$carte->getCategorie()], $cartePoseeTrait);
                        $partie->setPlateauJoueur1(json_encode($plateauJ1));

                        if (($key = array_search($cartePoseeTrait, $mainJ1)) !== false) {
                            unset($mainJ1[$key]);
                        }
                        $partie->setMainJoueur1(json_encode(array_values($mainJ1)));
                        $partie->setCompteurActionTour($partie->getCompteurActionTour() + 1);

                        $em->persist($partie);
                        $em->flush();
                    } else {
                        if (self::getCarte(end($plateauJ1[$carte->getCategorie()]))->getExtra() == 1) {
                            //on ajoute la carte
                            array_push($plateauJ1[$carte->getCategorie()], $cartePoseeTrait);
                            $partie->setPlateauJoueur1(json_encode($plateauJ1));

                            if (($key = array_search($cartePoseeTrait, $mainJ1)) !== false) {
                                unset($mainJ1[$key]);
                            }
                            $partie->setMainJoueur1(json_encode(array_values($mainJ1)));
                            $partie->setCompteurActionTour($partie->getCompteurActionTour() + 1);

                            $em->persist($partie);
                            $em->flush();
                        } else {
                            /**
                             * Flashbag disant que la dernière carte n'est pas une carte extra -> on ne peut pas poser
                             */
                        }
                    }
                } else {
                    //si la carte n'est pas une carte extra
                    //on vérifie si le plateau est vide
                    if (empty($plateauJ1[$carte->getCategorie()])) {
                        //si le tableau est vide on insère la carte
                        array_push($plateauJ1[$carte->getCategorie()], $cartePoseeTrait);
                        $partie->setPlateauJoueur1(json_encode($plateauJ1));

                        if (($key = array_search($cartePoseeTrait, $mainJ1)) !== false) {
                            unset($mainJ1[$key]);
                        }
                        $partie->setMainJoueur1(json_encode(array_values($mainJ1)));
                        $partie->setCompteurActionTour($partie->getCompteurActionTour() + 1);

                        $em->persist($partie);
                        $em->flush();
                    } else {
                        //on vérifie si la valeur de la dernière carte est bien plus petite que la carte qu'on pose
                        var_dump(self::getCarte(end($plateauJ1[$carte->getCategorie()]))->getValeur());
                        var_dump($carte->getValeur($cartePoseeTrait));
                        if (self::getCarte(end($plateauJ1[$carte->getCategorie()]))->getValeur() < $carte->getValeur($cartePoseeTrait)) {
                            //On ajoute la carte
                            array_push($plateauJ1[$carte->getCategorie()], $cartePoseeTrait);
                            $partie->setPlateauJoueur1(json_encode($plateauJ1));

                            if (($key = array_search($cartePoseeTrait, $mainJ1)) !== false) {
                                unset($mainJ1[$key]);
                            }
                            $partie->setMainJoueur1(json_encode(array_values($mainJ1)));
                            $partie->setCompteurActionTour($partie->getCompteurActionTour() + 1);

                            $em->persist($partie);
                            $em->flush();
                        } else {
                            /**
                             * Flashbag disant que la dernière carte a une valeur supérieure à la carte posée
                             */
                        }
                    }
                }
            } else {
                //on dit que la carte est pas dans la main
            }
        } elseif ($tourde == $joueur2){
            $mainJ2 = json_decode($partie->getMainJoueur2());

            //On vérifie que la carte est dans la main du joueur
            if (in_array($cartePoseeTrait, $mainJ2)) {
                $plateauJ2 = json_decode($partie->getPlateauJoueur2(), true);
                if ($carte->getExtra() == 1) {
                    //si la carte est une carte extra
                    //on vérifie que la dernière carte posée est une carte extra
                    if (self::getCarte(end($plateauJ2[$carte->getCategorie()]))->getExtra() == 1) {
                        //on ajoute la carte
                        array_push($plateauJ2[$carte->getCategorie()], $cartePoseeTrait);
                        $partie->setPlateauJoueur2(json_encode($plateauJ2));

                        if (($key = array_search($cartePoseeTrait, $mainJ2)) !== false) {
                            unset($mainJ2[$key]);
                        }
                        $partie->setMainJoueur2(json_encode(array_values($mainJ2)));
                        $partie->setCompteurActionTour($partie->getCompteurActionTour() + 1);

                        $em->persist($partie);
                        $em->flush();
                    } else {
                        /**
                         * Flashbag disant que la dernière carte n'est pas une carte extra -> on ne peut pas poser
                         */
                    }
                } else {
                    //si la carte n'est pas une carte extra
                    //on vérifie si le plateau est vide
                    if (empty($plateauJ2[$carte->getCategorie()])) {
                        //si le tableau est vide on insère la carte
                        array_push($plateauJ2[$carte->getCategorie()], $cartePoseeTrait);
                        $partie->setPlateauJoueur2(json_encode($plateauJ2));

                        if (($key = array_search($cartePoseeTrait, $mainJ2)) !== false) {
                            unset($mainJ2[$key]);
                        }
                        $partie->setMainJoueur2(json_encode(array_values($mainJ2)));
                        $partie->setCompteurActionTour($partie->getCompteurActionTour() + 1);

                        $em->persist($partie);
                        $em->flush();
                    } else {
                        //on vérifie si la valeur de la dernière carte est bien plus petite que la carte qu'on pose
                        var_dump(self::getCarte(end($plateauJ2[$carte->getCategorie()]))->getValeur());
                        var_dump($carte->getValeur($cartePoseeTrait));
                        if (self::getCarte(end($plateauJ2[$carte->getCategorie()]))->getValeur() < $carte->getValeur($cartePoseeTrait)) {
                            //On ajoute la carte
                            array_push($plateauJ2[$carte->getCategorie()], $cartePoseeTrait);
                            $partie->setPlateauJoueur2(json_encode($plateauJ2));

                            if (($key = array_search($cartePoseeTrait, $mainJ2)) !== false) {
                                unset($mainJ2[$key]);
                            }
                            $partie->setMainJoueur2(json_encode(array_values($mainJ2)));
                            $partie->setCompteurActionTour($partie->getCompteurActionTour() + 1);

                            $em->persist($partie);
                            $em->flush();
                        } else {
                            /**
                             * Flashbag disant que la dernière carte a une valeur supérieure à la carte posée
                             */
                        }
                    }
                }
            } else {
                //on dit que la carte est pas dans la main
            }

        } else {
        }
        return $this->redirectToRoute('afficher_partie', array('id' => $partie->getId()));
    }

    /**
     * @Route("/piocher/pioche/{partie}", name="piocher_carte_pioche")
     */
    public function piocherPioche(Request $request, Partie $partie){
        //TODO : piocher une carte dans le tableau des cartes et l'ajouter à la liste des cartes
        $tourde = $partie->getPartieTourJoueurId();
        $mainJ1 = json_decode($partie->getMainJoueur1());
        $mainJ2 = json_decode($partie->getMainJoueur2());
        $joueur1 = $partie->getJoueur1Id()->getId();
        $joueur2 = $partie->getJoueur2Id()->getId();
        $pioche = json_decode($partie->getPioche());

        $cartePiochee = end($pioche);
        echo $cartePiochee;
        if($tourde == $joueur1){
            if (count($mainJ1) == 7){
                //on continue
                array_push($mainJ1, $cartePiochee);
                $partie->setMainJoueur1(json_encode($mainJ1));
                array_pop($pioche);
                $partie->setPioche(json_encode($pioche));
                $partie->setCompteurActionTour($partie->getCompteurActionTour()+1);
                $em = $this->getDoctrine()->getManager();
                $em->persist($partie);
                $em->flush();
            } else {
                //on dit que le joueur a déjà le maximum de cartes dans sa main
            }

        } elseif ($tourde == $joueur2) {
            if (count($mainJ2) == 7){
                //on continue
                array_push($mainJ2, $cartePiochee);
                $partie->setMainJoueur2(json_encode($mainJ2));
                array_pop($pioche);
                $partie->setPioche(json_encode($pioche));
                $partie->setCompteurActionTour($partie->getCompteurActionTour()+1);
                $em = $this->getDoctrine()->getManager();
                $em->persist($partie);
                $em->flush();
            } else {
                //on dit que le joueur a déjà le maximum de cartes dans sa main
            }

        } else {
            echo "t'as rien à faire ici !";
        }
        return $this->redirectToRoute('afficher_partie', array('id' => $partie->getId()));
    }

    /**
     * @Route("/defausser/{partie}", name="defausser_carte")
     */
    public function poserDefausse(Request $request, Partie $partie){
        $cartePosee = $request->request->all();
        $cartePoseeTrait = $cartePosee['carte_id'];
        $tourde = $partie->getPartieTourJoueurId();
        $mainJ1 = json_decode($partie->getMainJoueur1());
        $mainJ2 = json_decode($partie->getMainJoueur2());
        $joueur1 = $partie->getJoueur1Id()->getId();
        $joueur2 = $partie->getJoueur2Id()->getId();
        $defausse = json_decode($partie->getDefausse(), true);

        $em = $this->getDoctrine()->getManager();
        $carte = $em->getRepository('AppBundle:Cartes')->findOneById($cartePoseeTrait);

        if($tourde == $joueur1){
            if (in_array($cartePoseeTrait, $mainJ1)){
                array_push($defausse[$carte->getCategorie()], $cartePoseeTrait);

                if(($key = array_search($cartePoseeTrait, $mainJ1)) !== false) {
                    unset($mainJ1[$key]);
                }

                $partie->setDefausse(json_encode($defausse));
                $partie->setMainJoueur1(json_encode(array_values($mainJ1)));
                $partie->setCompteurActionTour($partie->getCompteurActionTour()+1);
                $em = $this->getDoctrine()->getManager();
                $em->persist($partie);
                $em->flush();

            } else {

            }
        } elseif($tourde == $joueur2) {
            if (in_array($cartePoseeTrait, $mainJ2)){
                array_push($defausse[$carte->getCategorie()], $cartePoseeTrait);

                if(($key = array_search($cartePoseeTrait, $mainJ2)) !== false) {
                    unset($mainJ2[$key]);
                }

                $partie->setDefausse(json_encode($defausse));
                $partie->setMainJoueur2(json_encode(array_values($mainJ2)));
                $partie->setCompteurActionTour($partie->getCompteurActionTour()+1);
                $em = $this->getDoctrine()->getManager();
                $em->persist($partie);
                $em->flush();

            } else {

            }
        } else {

        }
        return $this->redirectToRoute('afficher_partie', array('id' => $partie->getId()));
    }

    /**
     * @Route("/piocher/defausse/{partie}", name="piocher_carte_defausse")
     */
    public function piocherDefausse(Request $request, Partie $partie){
        $cartePosee = $request->request->all();
        $cartePiocheeTrait = $cartePosee['carte_id'];
        $tourde = $partie->getPartieTourJoueurId();
        $mainJ1 = json_decode($partie->getMainJoueur1());
        $mainJ2 = json_decode($partie->getMainJoueur2());
        $joueur1 = $partie->getJoueur1Id()->getId();
        $joueur2 = $partie->getJoueur2Id()->getId();
        $defausse = json_decode($partie->getDefausse(), true);
        $em = $this->getDoctrine()->getManager();
        $carte = $em->getRepository('AppBundle:Cartes')->findOneById($cartePiocheeTrait);
        $categorie_carte = $carte->getCategorie();
        if($tourde == $joueur1){
            if(end($defausse[$categorie_carte]) == $cartePiocheeTrait){
                array_push($mainJ1, $cartePiocheeTrait);
                $partie->setMainJoueur1(json_encode($mainJ1));
                array_pop($defausse[$categorie_carte]);
                $partie->setDefausse(json_encode($defausse));
                $partie->setCompteurActionTour($partie->getCompteurActionTour()+1);
                $em->persist($partie);
                $em->flush();
            } else {

            }
        } elseif ($tourde == $joueur2) {
            if(end($defausse[$categorie_carte]) == $cartePiocheeTrait){
                array_push($mainJ2, $cartePiocheeTrait);
                $partie->setMainJoueur2(json_encode($mainJ2));
                array_pop($defausse[$categorie_carte]);
                $partie->setDefausse(json_encode($defausse));
                $partie->setCompteurActionTour($partie->getCompteurActionTour()+1);
                $em->persist($partie);
                $em->flush();
            } else {

            }
        } else {

        }
        return $this->redirectToRoute('afficher_partie', array('id' => $partie->getId()));
    }

    /**
     * @param Parties $id
     * @Route("/afficher/jeu/{id}", name="afficher_jeu")
     * @Method("GET")
     */
    public function afficherJeu(Partie $id){
        $user = $this->getUser();
        $userid = $this->getUser()->getId();

        if ($userid == $id->getJoueur1Id()->getId() || $userid == $id->getJoueur2Id()->getId()){
            $cartes = $this->getDoctrine()->getRepository('AppBundle:Cartes')->getAll();

            $plateau['mainJ1'] = json_decode($id->getMainJoueur1());
            $plateau['mainJ2'] = json_decode($id->getMainJoueur2());
            $plateau['pioche'] = json_decode($id->getPioche());
            $plateau['plateauJ1'] = json_decode($id->getPlateauJoueur1());
            $plateau['plateauJ2'] = json_decode($id->getPlateauJoueur2());
            $plateau['defausse'] = json_decode($id->getDefausse());

            return $this->render('parties/plateau.html.twig',
                [
                    'cartes' => $cartes,
                    'partie' => $id,
                    'user' => $user,
                    'plateau' => $plateau,
                ]
            );
        }
        return $this->render('parties/erreurs/non-joueur.html.twig');
    }

    /**
     * @Route("/changertour/{partie}", name="changer_tour")
     */
    public function changerTour(Request $request, Partie $partie){
        $pioche = json_decode($partie->getPioche());
        $joueur1 = $partie->getJoueur1Id()->getId();
        $joueur2 = $partie->getJoueur2Id()->getId();
        $plateauJ1 = json_decode($partie->getPlateauJoueur1(), true);
        $plateauJ2 = json_decode($partie->getPlateauJoueur2(), true);
        $tourde = $partie->getPartieTourJoueurId();
        $em = $this->getDoctrine()->getManager();
        if (count($pioche) == 0){
            if ($partie->getScoreJoueur1() > $partie->getScoreJoueur2()){
                //On met le joueur 1 gagnant
                $partie->getJoueur1Id()->setPoints($partie->getJoueur1Id()->getPoints() + 20);
                if (($partie->getJoueur2Id()->getPoints() - 10) < 0){
                    $partie->getJoueur2Id()->setPoints(0);
                } else {
                    $partie->getJoueur2Id()->setPoints($partie->getJoueur2Id()->getPoints() - 10);
                }

                $partie->getJoueur1Id()->setParties_Gagnees($partie->getJoueur1Id()->getParties_Gagnees() + 1);
                $partie->getJoueur2Id()->setParties_Perdues($partie->getJoueur2Id()->getParties_Perdues() + 1);
                $em->persist($partie);
                $em->flush();
                return $this->render('parties/fin-partie.html.twig');
            } elseif($partie->getScoreJoueur1() < $partie->getScoreJoueur2()) {
                //On met le joueur 2 gagnant
                $partie->getJoueur2Id()->setPoints($partie->getJoueur2Id()->getPoints() + 20);
                if (($partie->getJoueur1Id()->getPoints() - 10) < 0){
                    $partie->getJoueur1Id()->setPoints(0);
                } else {
                    $partie->getJoueur1Id()->setPoints($partie->getJoueur1Id()->getPoints() - 10);
                }

                $partie->getJoueur2Id()->setParties_Gagnees($partie->getJoueur2Id()->getParties_Gagnees() + 1);
                $partie->getJoueur1Id()->setParties_Perdues($partie->getJoueur1Id()->getParties_Perdues() + 1);
                $em->persist($partie);
                $em->flush();
                return $this->render('parties/fin-partie.html.twig');
            } else {
                //On met les 2 joueurs à égalité
            }
            $partie->setTerminee(1);
            $em->persist($partie);
            $em->flush();
        } else {
            //on provoque le changement de tour
            if ($tourde == $joueur1){
                //on set le tourjoueurid à l'id du joueur 2
                $partie->setPartieTourJoueurId($joueur2);
                //on remet à 0 le compteur de tours
                $partie->setCompteurActionTour(0);
                //on compte le score du joueur 1
                $tabPoints = $plateauJ1;
                $extraAperitif = 0;
                $extraEntree = 0;
                $extraPlat = 0;
                $extraLaitage = 0;
                $extraDessert = 0;
                $tabAperitif = array();
                $tabEntree = array();
                $tabPlat = array();
                $tabLaitage = array();
                $tabDessert = array();
                foreach ($tabPoints['aperitif'] as $valeur){
                    $carteTrait = self::getCarte($valeur)->getValeur();
                    array_push($tabAperitif, $carteTrait);
                    if ($carteTrait == 0){
                        $extraAperitif++;
                    }
                }
                foreach ($tabPoints['entree'] as $valeur){
                    $carteTrait = self::getCarte($valeur)->getValeur();
                    array_push($tabEntree, $carteTrait);
                    if ($carteTrait == 0){
                        $extraEntree++;
                    }
                }
                foreach ($tabPoints['plat'] as $valeur){
                    $carteTrait = self::getCarte($valeur)->getValeur();
                    array_push($tabPlat, $carteTrait);
                    if ($carteTrait == 0){
                        $extraPlat++;
                    }
                }
                foreach ($tabPoints['laitage'] as $valeur){
                    $carteTrait = self::getCarte($valeur)->getValeur();
                    array_push($tabLaitage, $carteTrait);
                    if ($carteTrait == 0){
                        $extraLaitage++;
                    }
                }
                foreach ($tabPoints['dessert'] as $valeur){
                    $carteTrait = self::getCarte($valeur)->getValeur();
                    array_push($tabDessert, $carteTrait);
                    if ($carteTrait == 0){
                        $extraDessert++;
                    }
                }
                $score = ($extraAperitif + 1) * array_sum($tabAperitif) + ($extraEntree + 1) * array_sum($tabEntree) + ($extraPlat + 1) * array_sum($tabPlat) + ($extraLaitage + 1) * array_sum($tabLaitage) + ($extraDessert + 1) * array_sum($tabDessert);
                $partie->setScoreJoueur1($score);

                $em = $this->getDoctrine()->getManager();
                $em->persist($partie);
                $em->flush();
            } elseif($tourde == $joueur2) {
                //on set le tourjoueurid à l'id du joueur 2
                $partie->setPartieTourJoueurId($joueur1);
                //on remet à 0 le compteur de tours
                $partie->setCompteurActionTour(0);
                //on compte le score du joueur 2
                $tabPoints = $plateauJ2;
                $extraAperitif = 0;
                $extraEntree = 0;
                $extraPlat = 0;
                $extraLaitage = 0;
                $extraDessert = 0;
                $tabAperitif = array();
                $tabEntree = array();
                $tabPlat = array();
                $tabLaitage = array();
                $tabDessert = array();
                foreach ($tabPoints['aperitif'] as $valeur){
                    $carteTrait = self::getCarte($valeur)->getValeur();
                    array_push($tabAperitif, $carteTrait);
                    if ($carteTrait == 0){
                        $extraAperitif++;
                    }
                }
                foreach ($tabPoints['entree'] as $valeur){
                    $carteTrait = self::getCarte($valeur)->getValeur();
                    array_push($tabEntree, $carteTrait);
                    if ($carteTrait == 0){
                        $extraEntree++;
                    }
                }
                foreach ($tabPoints['plat'] as $valeur){
                    $carteTrait = self::getCarte($valeur)->getValeur();
                    array_push($tabPlat, $carteTrait);
                    if ($carteTrait == 0){
                        $extraPlat++;
                    }
                }
                foreach ($tabPoints['laitage'] as $valeur){
                    $carteTrait = self::getCarte($valeur)->getValeur();
                    array_push($tabLaitage, $carteTrait);
                    if ($carteTrait == 0){
                        $extraLaitage++;
                    }
                }
                foreach ($tabPoints['dessert'] as $valeur){
                    $carteTrait = self::getCarte($valeur)->getValeur();
                    array_push($tabDessert, $carteTrait);
                    if ($carteTrait == 0){
                        $extraDessert++;
                    }
                }
                $score = ($extraAperitif + 1) * array_sum($tabAperitif) + ($extraEntree + 1) * array_sum($tabEntree) + ($extraPlat + 1) * array_sum($tabPlat) + ($extraLaitage + 1) * array_sum($tabLaitage) + ($extraDessert + 1) * array_sum($tabDessert);
                $partie->setScoreJoueur2($score);

                $em = $this->getDoctrine()->getManager();
                $em->persist($partie);
                $em->flush();
            }
        }
        return $this->redirectToRoute('fin_partie', array('id' => $partie->getId()));
    }

    /**
     * @Route("/fin/{partie}", name="fin_partie")
     */
    public function finPartie(Partie $partie){
        $this->renderView(':parties:fin-partie.html.twig');
    }

}