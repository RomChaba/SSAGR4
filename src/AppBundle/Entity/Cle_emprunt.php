<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cle_emprunt
 *
 * @ORM\Table(name="cle_emprunt")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Cle_empruntRepository")
 */
class Cle_emprunt
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
     * @ORM\ManyToOne(targetEntity="Emprunt")
     */
    private $empruntId;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Cle")
     */
    private $cleId;

    /**
     * @var bool
     *
     * @ORM\Column(name="rendu", type="boolean")
     */
    private $rendu;


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
     * Set empruntId
     *
     * @param integer $empruntId
     *
     * @return Cle_emprunt
     */
    public function setEmpruntId($empruntId)
    {
        $this->empruntId = $empruntId;

        return $this;
    }

    /**
     * Get empruntId
     *
     * @return int
     */
    public function getEmpruntId()
    {
        return $this->empruntId;
    }

    /**
     * Set cleId
     *
     * @param integer $cleId
     *
     * @return Cle_emprunt
     */
    public function setCleId($cleId)
    {
        $this->cleId = $cleId;

        return $this;
    }

    /**
     * Get cleId
     *
     * @return int
     */
    public function getCleId()
    {
        return $this->cleId;
    }

    /**
     * Set rendu
     *
     * @param boolean $rendu
     *
     * @return Cle_emprunt
     */
    public function setRendu($rendu)
    {
        $this->rendu = $rendu;

        return $this;
    }

    /**
     * Get rendu
     *
     * @return bool
     */
    public function getRendu()
    {
        return $this->rendu;
    }
}

