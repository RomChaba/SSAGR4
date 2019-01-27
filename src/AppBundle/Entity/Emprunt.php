<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emprunt
 *
 * @ORM\Table(name="emprunt")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmpruntRepository")
 */
class Emprunt
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
     * @ORM\Column(name="idVehicule", type="integer")
     */
    private $idVehicule;

    /**
     * @var int
     *
     * @ORM\Column(name="idSite", type="integer")
     */
    private $idSite;

    /**
     * @var int
     *
     * @ORM\Column(name="idLocalisationCle", type="integer")
     */
    private $idLocalisationCle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEmprunt", type="datetime")
     */
    private $dateEmprunt;

    /**
     * @var string
     *
     * @ORM\Column(name="dureeLocation", type="string", length=255)
     */
    private $dureeLocation;


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
     * Set idVehicule
     *
     * @param integer $idVehicule
     *
     * @return Emprunt
     */
    public function setIdVehicule($idVehicule)
    {
        $this->idVehicule = $idVehicule;

        return $this;
    }

    /**
     * Get idVehicule
     *
     * @return int
     */
    public function getIdVehicule()
    {
        return $this->idVehicule;
    }

    /**
     * Set idSite
     *
     * @param integer $idSite
     *
     * @return Emprunt
     */
    public function setIdSite($idSite)
    {
        $this->idSite = $idSite;

        return $this;
    }

    /**
     * Get idSite
     *
     * @return int
     */
    public function getIdSite()
    {
        return $this->idSite;
    }

    /**
     * Set idLocalisationCle
     *
     * @param integer $idLocalisationCle
     *
     * @return Emprunt
     */
    public function setIdLocalisationCle($idLocalisationCle)
    {
        $this->idLocalisationCle = $idLocalisationCle;

        return $this;
    }

    /**
     * Get idLocalisationCle
     *
     * @return int
     */
    public function getIdLocalisationCle()
    {
        return $this->idLocalisationCle;
    }

    /**
     * Set dateEmprunt
     *
     * @param \DateTime $dateEmprunt
     *
     * @return Emprunt
     */
    public function setDateEmprunt($dateEmprunt)
    {
        $this->dateEmprunt = $dateEmprunt;

        return $this;
    }

    /**
     * Get dateEmprunt
     *
     * @return \DateTime
     */
    public function getDateEmprunt()
    {
        return $this->dateEmprunt;
    }

    /**
     * Set dureeLocation
     *
     * @param string $dureeLocation
     *
     * @return Emprunt
     */
    public function setDureeLocation($dureeLocation)
    {
        $this->dureeLocation = $dureeLocation;

        return $this;
    }

    /**
     * Get dureeLocation
     *
     * @return string
     */
    public function getDureeLocation()
    {
        return $this->dureeLocation;
    }
}

