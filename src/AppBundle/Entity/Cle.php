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
     * @ORM\ManyToOne(targetEntity="Vehicule")
     */
    private $vehicule_id;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var bool
     *
     * @ORM\Column(name="perdu", type="boolean")
     */
    private $perdu;

    /**
     * @var Cle
     *
     * @ORM\OneToMany(targetEntity="Cle_emprunt",mappedBy="cleId")
     */
    private $listeEmprunt;


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
     * @return int
     */
    public function getVehiculeId()
    {
        return $this->vehicule_id;
    }

    /**
     * @param int $vehicule_id
     */
    public function setVehiculeId($vehicule_id)
    {
        $this->vehicule_id = $vehicule_id;
    }

    /**
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param string $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * @return bool
     */
    public function isPerdu()
    {
        return $this->perdu;
    }

    /**
     * @param bool $perdu
     */
    public function setPerdu($perdu)
    {
        $this->perdu = $perdu;
    }


}

