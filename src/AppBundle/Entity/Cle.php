<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cle
 *
 * @ORM\Table(name="cle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CleRepository")
 */
class Cle
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
     * @ORM\ManyToOne(targetEntity="Vehicule")
     */
    private $idVehicule;

    /**
     * @var bool
     *
     * @ORM\Column(name="boolVehiculeDispo", type="boolean")
     */
    private $boolVehiculeDispo;

    /**
     * @var bool
     *
     * @ORM\Column(name="boolClePerdus", type="boolean")
     */
    private $boolClePerdus;


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
     * @return Cle
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
     * Set boolVehiculeDispo
     *
     * @param boolean $boolVehiculeDispo
     *
     * @return Cle
     */
    public function setBoolVehiculeDispo($boolVehiculeDispo)
    {
        $this->boolVehiculeDispo = $boolVehiculeDispo;

        return $this;
    }

    /**
     * Get boolVehiculeDispo
     *
     * @return bool
     */
    public function getBoolVehiculeDispo()
    {
        return $this->boolVehiculeDispo;
    }

    /**
     * Set boolClePerdus
     *
     * @param boolean $boolClePerdus
     *
     * @return Cle
     */
    public function setBoolClePerdus($boolClePerdus)
    {
        $this->boolClePerdus = $boolClePerdus;

        return $this;
    }

    /**
     * Get boolClePerdus
     *
     * @return bool
     */
    public function getBoolClePerdus()
    {
        return $this->boolClePerdus;
    }
}

