<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     * @ORM\Column(name="parties_gagnees", type="integer")
     */
    private $parties_gagnees = 0;

    /**
     * @var int
     * @ORM\Column(name="parties_perdues", type="integer")
     */
    private $parties_perdues = 0;

    /**
     * @var string
     * @ORM\Column(name="avatar", type="string", length=255)
     */
    private $avatar = "https://image.freepik.com/free-icon/male-profile-user-shadow_318-40244.jpg";

    /**
     * @var int
     * @ORM\Column(name="points", type="integer")
     */
    private $points = 0;

    public function __construct()
    {
        parent::__construct();
        // your own logic
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
     * Get avatar
     *
     * @return String
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set avatar
     *
     * @param String $avatar
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

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
}
