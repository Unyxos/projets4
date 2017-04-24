<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partie
 *
 * @ORM\Table(name="partie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartieRepository")
 */
class Partie
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="parties_1")
     */
    private $joueur1Id;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="parties_2")
     */
    private $joueur2Id;

    /**
     * @var array
     *
     * @ORM\Column(name="main_joueur_1", type="json_array", nullable=true)
     */
    private $mainJoueur1;

    /**
     * @var array
     *
     * @ORM\Column(name="main_joueur_2", type="json_array", nullable=true)
     */
    private $mainJoueur2;

    /**
     * @var int
     *
     * @ORM\Column(name="partie_tour_joueur_id", type="integer")
     */
    private $partieTourJoueurId;

    /**
     * @var int
     *
     * @ORM\Column(name="partie_compteur_action_tour", type="integer")
     */
    private $compteurActionTour;

    /**
     * @var array
     *
     * @ORM\Column(name="pioche", type="json_array", nullable=true)
     */
    private $pioche;

    /**
     * @var array
     *
     * @ORM\Column(name="plateau_joueur_1", type="json_array", nullable=true)
     */
    private $plateauJoueur1;

    /**
     * @var array
     *
     * @ORM\Column(name="plateau_joueur_2", type="json_array", nullable=true)
     */
    private $plateauJoueur2;

    /**
     * @var array
     *
     * @ORM\Column(name="defausse", type="json_array", nullable=true)
     */
    private $defausse;

    /**
     * @var string
     *
     * @ORM\Column(name="date_creation", type="string")
     */
    private $dateCreation;

    /**
     * @var int
     *
     * @ORM\Column(name="score_joueur_1", type="integer", nullable=true)
     */
    private $scoreJoueur1;

    /**
     * @var int
     *
     * @ORM\Column(name="score_joueur_2", type="integer", nullable=true)
     */
    private $scoreJoueur2;

    /**
     * @var bool
     *
     * @ORM\Column(name="terminee", type="boolean")
     */
    private $terminee;

    public function __construct()
    {
        $this->dateCreation = date('Y-m-d H:i:s');
        $this->scoreJoueur1 = 0;
        $this->scoreJoueur2 = 0;
        $this->terminee = 0;

    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set joueur1
     *
     * @param \AppBundle\Entity\User $joueur1Id
     *
     * @return Partie
     */
    public function setJoueur1Id(\AppBundle\Entity\User $joueur1Id = null)
    {
        $this->joueur1Id = $joueur1Id;
        return $this;
    }
    /**
     * Get joueur1Id
     *
     * @return \AppBundle\Entity\User
     */
    public function getJoueur1Id()
    {
        return $this->joueur1Id;
    }
    /**
     * Set joueur2Id
     *
     * @param \AppBundle\Entity\User $joueur2Id
     *
     * @return Partie
     */
    public function setJoueur2Id(\AppBundle\Entity\User $joueur2Id = null)
    {
        $this->joueur2Id = $joueur2Id;
        return $this;
    }
    /**
     * Get joueur2
     *
     * @return \AppBundle\Entity\User
     */
    public function getJoueur2Id()
    {
        return $this->joueur2Id;
    }

    /**
     * Set mainJoueur1
     *
     * @param array $mainJoueur1
     *
     * @return Partie
     */
    public function setMainJoueur1($mainJoueur1)
    {
        $this->mainJoueur1 = $mainJoueur1;

        return $this;
    }

    /**
     * Get mainJoueur1
     *
     * @return array
     */
    public function getMainJoueur1()
    {
        return $this->mainJoueur1;
    }

    /**
     * Set mainJoueur2
     *
     * @param array $mainJoueur2
     *
     * @return Partie
     */
    public function setMainJoueur2($mainJoueur2)
    {
        $this->mainJoueur2 = $mainJoueur2;

        return $this;
    }

    /**
     * Get mainJoueur2
     *
     * @return array
     */
    public function getMainJoueur2()
    {
        return $this->mainJoueur2;
    }

    /**
     * Set partieTourJoueurId
     *
     * @param integer $partieTourJoueurId
     *
     * @return Partie
     */
    public function setPartieTourJoueurId($partieTourJoueurId)
    {
        $this->partieTourJoueurId = $partieTourJoueurId;

        return $this;
    }

    /**
     * Get partieTourJoueurId
     *
     * @return int
     */
    public function getPartieTourJoueurId()
    {
        return $this->partieTourJoueurId;
    }

    /**
     * Set pioche
     *
     * @param array $pioche
     *
     * @return Partie
     */
    public function setPioche($pioche)
    {
        $this->pioche = $pioche;

        return $this;
    }

    /**
     * Get pioche
     *
     * @return array
     */
    public function getPioche()
    {
        return $this->pioche;
    }

    /**
     * Set plateauJoueur1
     *
     * @param array $plateauJoueur1
     *
     * @return Partie
     */
    public function setPlateauJoueur1($plateauJoueur1)
    {
        $this->plateauJoueur1 = $plateauJoueur1;

        return $this;
    }

    /**
     * Get plateauJoueur1
     *
     * @return array
     */
    public function getPlateauJoueur1()
    {
        return $this->plateauJoueur1;
    }

    /**
     * Set plateauJoueur2
     *
     * @param array $plateauJoueur2
     *
     * @return Partie
     */
    public function setPlateauJoueur2($plateauJoueur2)
    {
        $this->plateauJoueur2 = $plateauJoueur2;

        return $this;
    }

    /**
     * Get plateauJoueur2
     *
     * @return array
     */
    public function getPlateauJoueur2()
    {
        return $this->plateauJoueur2;
    }

    /**
     * Set defausse
     *
     * @param array $defausse
     *
     * @return Partie
     */
    public function setDefausse($defausse)
    {
        $this->defausse = $defausse;

        return $this;
    }

    /**
     * Get defausse
     *
     * @return array
     */
    public function getDefausse()
    {
        return $this->defausse;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Partie
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set scoreJoueur1
     *
     * @param integer $scoreJoueur1
     *
     * @return Partie
     */
    public function setScoreJoueur1($scoreJoueur1)
    {
        $this->scoreJoueur1 = $scoreJoueur1;

        return $this;
    }

    /**
     * Get scoreJoueur1
     *
     * @return int
     */
    public function getScoreJoueur1()
    {
        return $this->scoreJoueur1;
    }

    /**
     * Set scoreJoueur2
     *
     * @param integer $scoreJoueur2
     *
     * @return Partie
     */
    public function setScoreJoueur2($scoreJoueur2)
    {
        $this->scoreJoueur2 = $scoreJoueur2;

        return $this;
    }

    /**
     * Get scoreJoueur2
     *
     * @return int
     */
    public function getScoreJoueur2()
    {
        return $this->scoreJoueur2;
    }

    /**
     * Set terminee
     *
     * @param boolean $terminee
     *
     * @return Partie
     */
    public function setTerminee($terminee)
    {
        $this->terminee = $terminee;

        return $this;
    }

    /**
     * Get terminee
     *
     * @return bool
     */
    public function getTerminee()
    {
        return $this->terminee;
    }

    /**
     * Set compteuractiontour
     *
     * @param integer $compteurActionTour
     *
     * @return Partie
     */
    public function setCompteurActionTour($compteurActionTour)
    {
        $this->compteurActionTour = $compteurActionTour;

        return $this;
    }

    /**
     * Get compteuractiontour
     *
     * @return int
     */
    public function getCompteurActionTour()
    {
        return $this->compteurActionTour;
    }
}

