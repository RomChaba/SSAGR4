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
     * @ORM\Column(name="idSiteDepart", type="integer")
     */
    private $idSiteDepart;
    /**
     * @var int
     *
     * @ORM\Column(name="idSiteArrivee", type="integer")
     */
    private $idSiteArrivee;

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
     * @ORM\Column(name="dureeLocation", type="integer", length=255)
     */
    private $nbJourLocation;

    /**
     * @ORM\ManyToMany(targetEntity="Personne", inversedBy="emprunt")
     * @ORM\JoinTable(name="emprunt__personne")
     */
    private $listePersonne;

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
     * @param integer $idSiteDepart
     *
     * @return Emprunt
     */
    public function setIdSiteDepart($idSiteDepart)
    {
        $this->idSiteDepart = $idSiteDepart;

        return $this;
    }

    /**
     * Get idSite
     *
     * @return int
     */
    public function getIdSiteDepart()
    {
        return $this->idSiteDepart;
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
     * @param string $nbJourLocation
     *
     * @return Emprunt
     */
    public function setNbJourLocation($nbJourLocation)
    {
        $this->nbJourLocation = $nbJourLocation;

        return $this;
    }

    /**
     * Get dureeLocation
     *
     * @return string
     */
    public function getNbJourLocation()
    {
        return $this->nbJourLocation;
    }

    /**
     * @return mixed
     */
    public function getListePersonne()
    {
        return $this->listePersonne;
    }

    /**
     * @param mixed $listePersonne
     */
    public function setListePersonne($listePersonne)
    {
        $this->listePersonne = $listePersonne;
    }

    /**
     * @return int
     */
    public function getIdSiteArrivee()
    {
        return $this->idSiteArrivee;
    }

    /**
     * @param int $idSiteArrivee
     */
    public function setIdSiteArrivee($idSiteArrivee)
    {
        $this->idSiteArrivee = $idSiteArrivee;
    }

    


}

