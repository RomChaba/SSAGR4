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
     * @var Emprunt
     *
     * @ORM\ManyToOne(targetEntity="Emprunt", inversedBy="listePersonne")
     */
    private $empruntId;

    /**
     * @var Personne
     *
     * @ORM\ManyToOne(targetEntity="Personne", inversedBy="listeEmprunt")
     */
    private $personneId;

    /**
     * @var bool
     *
     * @ORM\Column(name="conducteur", type="boolean")
     */
    private $conducteur;



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
     * @return Emprunt_Personne
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
     * Set personneId
     *
     * @param integer $personneId
     *
     * @return Emprunt_Personne
     */
    public function setPersonneId($personneId)
    {
        $this->personneId = $personneId;

        return $this;
    }

    /**
     * Get personneId
     *
     * @return int
     */
    public function getPersonneId()
    {
        return $this->personneId;
    }

    /**
     * Set conducteur
     *
     * @param boolean $conducteur
     *
     * @return Emprunt_Personne
     */
    public function setConducteur($conducteur)
    {
        $this->conducteur = $conducteur;

        return $this;
    }

    /**
     * Get conducteur
     *
     * @return bool
     */
    public function getConducteur()
    {
        return $this->conducteur;
    }
}

