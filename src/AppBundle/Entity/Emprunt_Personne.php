<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emprunt_Personne
 *
 * @ORM\Table(name="emprunt__personne")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Emprunt_PersonneRepository")
 */
class Emprunt_Personne
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
     * @ORM\Column(name="idEmprunt", type="integer")
     */
    private $idEmprunt;

    /**
     * @var int
     *
     * @ORM\Column(name="idPersonne", type="integer")
     */
    private $idPersonne;

    /**
     * @var bool
     *
     * @ORM\Column(name="boolConducteur", type="boolean")
     */
    private $boolConducteur;


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
     * Set idEmprunt
     *
     * @param integer $idEmprunt
     *
     * @return Emprunt_Personne
     */
    public function setIdEmprunt($idEmprunt)
    {
        $this->idEmprunt = $idEmprunt;

        return $this;
    }

    /**
     * Get idEmprunt
     *
     * @return int
     */
    public function getIdEmprunt()
    {
        return $this->idEmprunt;
    }

    /**
     * Set idPersonne
     *
     * @param integer $idPersonne
     *
     * @return Emprunt_Personne
     */
    public function setIdPersonne($idPersonne)
    {
        $this->idPersonne = $idPersonne;

        return $this;
    }

    /**
     * Get idPersonne
     *
     * @return int
     */
    public function getIdPersonne()
    {
        return $this->idPersonne;
    }

    /**
     * Set boolConducteur
     *
     * @param boolean $boolConducteur
     *
     * @return Emprunt_Personne
     */
    public function setBoolConducteur($boolConducteur)
    {
        $this->boolConducteur = $boolConducteur;

        return $this;
    }

    /**
     * Get boolConducteur
     *
     * @return bool
     */
    public function getBoolConducteur()
    {
        return $this->boolConducteur;
    }
}

