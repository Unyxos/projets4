<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use FOS\MessageBundle\Model\ParticipantInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @Vich\Uploadable
 */
class User extends BaseUser implements ParticipantInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="sexe", type="string")
     *
     * @Assert\NotBlank(message="Entrez votre sexe.", groups={"Registration", "Profile"})
     */
    protected $sexe;

    /**
     * @var int
     * @ORM\Column(name="parties_gagnees", type="integer")
     */
    protected $parties_gagnees = 0;

    /**
     * @var int
     * @ORM\Column(name="parties_perdues", type="integer")
     */
    protected $parties_perdues = 0;

    /**
     * @var int
     * @ORM\Column(name="points", type="integer")
     */
    protected $points = 0;

    /**
     * @var string
     * @ORM\Column(name="nom", type="string", nullable=true)
     */
    protected $nom;

    /**
     * @var string
     * @ORM\Column(name="prenom", type="string", nullable=true)
     */
    protected $prenom;

    /**
     * @var string
     * @ORM\Column(name="birthday", type="string")
     */
    protected $birthday;

    //On déclare les champs relatifs à VichUploadBundle
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="avatar_image", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName = 'male-profile-user-shadow_318-40244.jpg';

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Partie", mappedBy="joueur1Id")
     */
    private $parties_1;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Partie", mappedBy="joueur2Id")
     */
    private $parties_2;

    private $parties;

    //Ici le __construct() appelle les éléments de FOS User Bundle par défaut, on y touche pas.
    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->roles = array('ROLE_RANG_1');
        $this->parties_1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parties_2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parties = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getParties()
    {
        $this->parties[] = $this->parties_1;
        $this->parties[] = $this->parties_2;
        return $this->parties;
    }

    /**
     * Get parties_gagnees
     *
     * @return String
     */
    public function getParties_Gagnees()
    {
        return $this->parties_gagnees;
    }

    public function getPartiesGagnees()
    {
        return $this->parties_gagnees;
    }

    /**
     * Set parties_gagnees
     *
     * @param String $parties_gagnees
     * @return User
     */
    public function setParties_Gagnees($parties_gagnees)
    {
        $this->parties_gagnees = $parties_gagnees;

        return $this;
    }

    /**
     * Get parties_perdues
     *
     * @return String
     */
    public function getParties_Perdues()
    {
        return $this->parties_perdues;
    }

    public function getPartiesPerdues()
    {
        return $this->parties_perdues;
    }

    /**
     * Set parties_perdues
     *
     * @param String $parties_perdues
     * @return User
     */
    public function setParties_Perdues($parties_perdues)
    {
        $this->parties_perdues = $parties_perdues;

        return $this;
    }

    /**
     * Get points
     *
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set points
     *
     * @param int $points
     * @return User
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Product
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Product
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getSexe()
    {
        return $this->sexe;
    }

    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }
}
