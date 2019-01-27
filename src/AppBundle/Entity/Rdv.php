<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rdv
 *
 * @ORM\Table(name="rdv")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RdvRepository")
 */
class Rdv
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
     * @ORM\Column(name="idSite", type="integer")
     */
    private $idSite;

    /**
     * @var string
     *
     * @ORM\Column(name="horraire", type="string", length=255)
     */
    private $horraire;


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
     * @return Rdv
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
     * Set idSite
     *
     * @param integer $idSite
     *
     * @return Rdv
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
     * Set horraire
     *
     * @param string $horraire
     *
     * @return Rdv
     */
    public function setHorraire($horraire)
    {
        $this->horraire = $horraire;

        return $this;
    }

    /**
     * Get horraire
     *
     * @return string
     */
    public function getHorraire()
    {
        return $this->horraire;
    }
}

