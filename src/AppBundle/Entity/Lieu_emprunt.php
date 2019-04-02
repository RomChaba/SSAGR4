<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lieu_emprunt
 *
 * @ORM\Table(name="lieu_emprunt")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Lieu_empruntRepository")
 */
class Lieu_emprunt
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
     * @ORM\ManyToOne(targetEntity="Emprunt", inversedBy="listeLieux")
     */
    private $empruntId;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Lieu", inversedBy="listeEmprunt")
     */
    private $lieuId;

    /**
     * @var bool
     *
     * @ORM\Column(name="depart", type="boolean")
     */
    private $depart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEtHeure", type="datetime")
     */
    private $dateEtHeure;


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
     * @return Lieu_emprunt
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
     * Set lieuId
     *
     * @param integer $lieuId
     *
     * @return Lieu_emprunt
     */
    public function setLieuId($lieuId)
    {
        $this->lieuId = $lieuId;

        return $this;
    }

    /**
     * Get lieuId
     *
     * @return int
     */
    public function getLieuId()
    {
        return $this->lieuId;
    }

    /**
     * Set depart
     *
     * @param boolean $depart
     *
     * @return Lieu_emprunt
     */
    public function setDepart($depart)
    {
        $this->depart = $depart;

        return $this;
    }

    /**
     * Get depart
     *
     * @return bool
     */
    public function getDepart()
    {
        return $this->depart;
    }

    /**
     * Set dateEtHeure
     *
     * @param \DateTime $dateEtHeure
     *
     * @return Lieu_emprunt
     */
    public function setDateEtHeure($dateEtHeure)
    {
        $this->dateEtHeure = $dateEtHeure;

        return $this;
    }

    /**
     * Get dateEtHeure
     *
     * @return \DateTime
     */
    public function getDateEtHeure()
    {
        return $this->dateEtHeure;
    }
}

