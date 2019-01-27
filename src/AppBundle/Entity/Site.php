<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Site
 *
 * @ORM\Table(name="site")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SiteRepository")
 */
class Site
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
     * @ORM\Column(name="coordGPS", type="string", length=255)
     */
    private $coordGPS;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var bool
     *
     * @ORM\Column(name="boolSiteOfficiel", type="boolean")
     */
    private $boolSiteOfficiel;


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
     * Set coordGPS
     *
     * @param string $coordGPS
     *
     * @return Site
     */
    public function setCoordGPS($coordGPS)
    {
        $this->coordGPS = $coordGPS;

        return $this;
    }

    /**
     * Get coordGPS
     *
     * @return string
     */
    public function getCoordGPS()
    {
        return $this->coordGPS;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Site
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set boolSiteOfficiel
     *
     * @param boolean $boolSiteOfficiel
     *
     * @return Site
     */
    public function setBoolSiteOfficiel($boolSiteOfficiel)
    {
        $this->boolSiteOfficiel = $boolSiteOfficiel;

        return $this;
    }

    /**
     * Get boolSiteOfficiel
     *
     * @return bool
     */
    public function getBoolSiteOfficiel()
    {
        return $this->boolSiteOfficiel;
    }
}

