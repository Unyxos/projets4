<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Rang
 *
 * @ORM\Table(name="rang")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RangRepository")
 * @Vich\Uploadable
 */
class Rang
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
     * @var string
     *
     * @ORM\Column(name="nom_rang", type="string", length=255, unique=true)
     */
    private $nomRang;

    /**
     * @var int
     *
     * @ORM\Column(name="points_debut", type="integer")
     */
    private $pointsDebut;

    /**
     * @var int
     *
     * @ORM\Column(name="points_fin", type="integer")
     */
    private $pointsFin;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255, unique=true)
     */
    private $role;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="rang_image", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

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
     * Set nomRang
     *
     * @param string $nomRang
     *
     * @return Rang
     */
    public function setNomRang($nomRang)
    {
        $this->nomRang = $nomRang;

        return $this;
    }

    /**
     * Get nomRang
     *
     * @return string
     */
    public function getNomRang()
    {
        return $this->nomRang;
    }

    /**
     * Set pointsDebut
     *
     * @param integer $pointsDebut
     *
     * @return Rang
     */
    public function setPointsDebut($pointsDebut)
    {
        $this->pointsDebut = $pointsDebut;

        return $this;
    }

    /**
     * Get pointsDebut
     *
     * @return int
     */
    public function getPointsDebut()
    {
        return $this->pointsDebut;
    }

    /**
     * Set pointsFin
     *
     * @param integer $pointsFin
     *
     * @return Rang
     */
    public function setPointsFin($pointsFin)
    {
        $this->pointsFin = $pointsFin;

        return $this;
    }

    /**
     * Get pointsFin
     *
     * @return int
     */
    public function getPointsFin()
    {
        return $this->pointsFin;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return Rang
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }
}

