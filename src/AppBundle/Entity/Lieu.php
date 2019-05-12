<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lieu
 *
 * @ORM\Table(name="lieu")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LieuRepository")
 */
class Lieu
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
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float")
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float")
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="coordGPS", type="string", length=255)
     */
    private $commentaire;

    /**
     * @var bool
     *
     * @ORM\Column(name="siteOfficiel", type="boolean")
     */
    private $siteOfficiel;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="Lieu_emprunt",mappedBy="lieuId")
     */
    private $listeEmprunt;


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
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @param string $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    /**
     * @return bool
     */
    public function isSiteOfficiel()
    {
        return $this->siteOfficiel;
    }

    /**
     * @param bool $siteOfficiel
     */
    public function setSiteOfficiel($siteOfficiel)
    {
        $this->siteOfficiel = $siteOfficiel;
    }

    public function __toString()
    {
        return '{"id":'.$this->getId().
            ',"libelle":"'.$this->getLibelle().'"'.
            ',"commentaire":"'.$this->getCommentaire().'"'.
            ',"latitude":"'.$this->getLatitude().'"'.
            ',"longitude":"'.$this->getLongitude().'"}';


    }


}

