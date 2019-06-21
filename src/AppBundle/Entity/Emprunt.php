<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @var Emprunt_Personne
     *
     * @ORM\OneToMany(targetEntity="Emprunt_Personne",mappedBy="empruntId", cascade={"remove", "persist"},fetch="EAGER")
     */
    private $listePersonne;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Lieu_emprunt",mappedBy="empruntId", cascade={"remove", "persist"},fetch="EAGER")
     */
    private $listeLieux;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Cle_emprunt",mappedBy="empruntId", cascade={"remove", "persist"},fetch="EAGER")
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
    public function getVehiculeId()
    {
        return $this->vehicule_id;
    }
    /**
     * @return Vehicule
     */
    public function getvehicule_id()
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

    /**
     * @return Emprunt_Personne
     */
    public function getListePersonne()
    {
        return $this->listePersonne;
    }

    /**
     * @param ArrayCollection $listePersonne
     */
    public function setListePersonne($listePersonne)
    {
        $this->listePersonne = $listePersonne;
    }

    /**
     * @return Lieu_emprunt
     */
    public function getListeLieux()
    {
        return $this->listeLieux;
    }

    /**
     * @param ArrayCollection $listeLieux
     */
    public function setListeLieux($listeLieux)
    {
        $this->listeLieux = $listeLieux;
    }

    /**
     * @return Cle
     */
    public function getListeCle()
    {
        return $this->listeCle;
    }

    /**
     * @param Cle $listeCle
     */
    public function setListeCle($listeCle)
    {
        $this->listeCle = $listeCle;
    }


    public function removePersonne($pers_co)
    {
        foreach ($this->getListePersonne() as $personne){
//            dump($personne);
            if($personne->getPersonneId()->getId() == $pers_co->getId()){
//                dump($personne->getPersonneId()->getId() == $pers_co->getId());

                /** @var Emprunt_Personne $test */
                $this->getListePersonne()->removeElement($personne);
                return;
            }
        }
    }



}

