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
     * @var Vehicule
     * @ORM\ManyToOne(targetEntity="Vehicule")
     */
    private $vehicule_id;


    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255)
     */
    private $commentaire;

    /**
     * @var Personne
     *
     * @ORM\OneToMany(targetEntity="Emprunt_Personne",mappedBy="empruntId")
     */
    private $listePersonne;

    /**
     * @var Lieu
     *
     * @ORM\OneToMany(targetEntity="Lieu_emprunt",mappedBy="empruntId")
     */
    private $listeLieux;

    /**
     * @var Cle
     *
     * @ORM\OneToMany(targetEntity="Cle_emprunt",mappedBy="empruntId")
     */
    private $listeCle;

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
     * @return Vehicule
     */
    public function getVehicule_Id()
    {
        return $this->vehicule_id;
    }

    /**
     * @param Vehicule $vehicule_id
     */
    public function setVehiculeId($vehicule_id)
    {
        $this->vehicule_id = $vehicule_id;
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



}

