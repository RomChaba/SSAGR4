<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Vehicule
 *
 * @ORM\Table(name="vehicule")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehiculeRepository")
 */
class Vehicule
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
     * @ORM\ManyToOne(targetEntity="Lieu")
     */
    private $lieu_id;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="couleur", type="string", length=255)
     */
    private $couleur;


    /**
     * @var string
     *
     * @ORM\Column(name="immatriculation", type="string", length=255)
     * @Assert\Length(min=7, minMessage="L'immatriculation doit contenir minimum 7 caractères", max=8, maxMessage="L'immatriculation doit contenir maximum 9 caractères")
     */
    private $immatriculation;

    /**
     * @var boolean
     * @ORM\ManyToOne(targetEntity="Emprunt")
     */
    private $disponibilite;

    /**
     * @Assert\IsTrue(message="L'immatriculation ne respecte pas le bon format")
     */
    public function isImmatriculation()
    {
        if (strlen($this->getImmatriculation()) <= 9 && preg_match("#^[0-9]{1,4}[A-Z]{1,4}[0-9]{1,2}$#", $this->getImmatriculation()))
        {
            return true;
        }
        elseif  (strlen($this->getImmatriculation()) <= 7 && preg_match("#^[A-Z]{1,2}[0-9]{1,3}[A-Z]{1,2}$#", $this->getImmatriculation()))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Vehicule constructor.
     * @param string $lieu_id
     * @param string $libelle
     * @param string $couleur
     * @param string $immatriculation
     * @param string $disponibilite
     */
    public function __construct($lieu_id, $libelle, $couleur, $immatriculation)
    {
        $this->lieu_id = $lieu_id;
        $this->libelle = $libelle;
        $this->couleur = $couleur;
        $this->immatriculation = $immatriculation;
//        $this->disponibilite = $disponibilite;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLieuId()
    {
        return $this->lieu_id;
    }

    /**
     * @param string $lieu_id
     */
    public function setLieuId($lieu_id)
    {
        $this->lieu_id = $lieu_id;
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
     * @return string
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * @param string $couleur
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;
    }

    /**
     * @return string
     */
    public function getImmatriculation()
    {
        return $this->immatriculation;
    }

    /**
     * @param string $immatriculation
     */
    public function setImmatriculation($immatriculation)
    {
        $immatFormat = str_replace(CHR(32),"",$immatriculation);
        $this->immatriculation = strtoupper($immatFormat);
    }

    /**
     * @return string
     */
    public function getDisponibilite()
    {
        return $this->disponibilite;
    }

    /**
     * @param string $disponibilite
     */
    public function setDisponibilite($disponibilite)
    {
        $this->disponibilite = $disponibilite;
    }

    public function __toString()
    {
        return ucfirst(strtolower($this->getLibelle())).' | '. $this->getImmatriculation();
    }


}

