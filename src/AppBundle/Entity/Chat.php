<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chat
 *
 * @ORM\Table(name="chat")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChatRepository")
 */
class Chat
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
     * @var int
     *
     * @ORM\Column(name="partie_id", type="integer")
     * @ORM\OneToOne(targetEntity="Partie", mappedBy="chat")
     */
    private $partieId;

    /**
     * @var int
     *
     * @ORM\Column(name="joueur_1_id", type="integer")
     */
    private $joueur1Id;

    /**
     * @var int
     *
     * @ORM\Column(name="joueur_2_id", type="integer")
     */
    private $joueur2Id;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_envoi", type="datetime")
     */
    private $dateEnvoi;


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
     * Set partieId
     *
     * @param integer $partieId
     *
     * @return Chat
     */
    public function setPartieId($partieId)
    {
        $this->partieId = $partieId;

        return $this;
    }

    /**
     * Get partieId
     *
     * @return int
     */
    public function getPartieId()
    {
        return $this->partieId;
    }

    /**
     * Set joueur1Id
     *
     * @param integer $joueur1Id
     *
     * @return Chat
     */
    public function setJoueur1Id($joueur1Id)
    {
        $this->joueur1Id = $joueur1Id;

        return $this;
    }

    /**
     * Get joueur1Id
     *
     * @return int
     */
    public function getJoueur1Id()
    {
        return $this->joueur1Id;
    }

    /**
     * Set joueur2Id
     *
     * @param integer $joueur2Id
     *
     * @return Chat
     */
    public function setJoueur2Id($joueur2Id)
    {
        $this->joueur2Id = $joueur2Id;

        return $this;
    }

    /**
     * Get joueur2Id
     *
     * @return int
     */
    public function getJoueur2Id()
    {
        return $this->joueur2Id;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Chat
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set dateEnvoi
     *
     * @param \DateTime $dateEnvoi
     *
     * @return Chat
     */
    public function setDateEnvoi($dateEnvoi)
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    /**
     * Get dateEnvoi
     *
     * @return \DateTime
     */
    public function getDateEnvoi()
    {
        return $this->dateEnvoi;
    }
}

