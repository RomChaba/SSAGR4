<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personne
 *
 * @ORM\Table(name="personne")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonneRepository")
 */
class Personne
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="motDePasse", type="string", length=255)
     */
    private $motDePasse;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, unique=true)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var bool
     *
     * @ORM\Column(name="boolPermis", type="boolean")
     */
    private $boolPermis;

    /**
     * @var bool
     *
     * @ORM\ManyToMany(targetEntity="Emprunt", mappedBy="listePersonne")
     */
    private $emprunt;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Personne
     */
    public function setNom($nom)
    {
        $this->nom = $this->_ENCRYPTE_DATA($nom);

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->_DECRYPTE_DATA($this->nom);
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Personne
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $this->_ENCRYPTE_DATA($prenom);

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->_DECRYPTE_DATA($this->prenom);
    }

    /**
     * Set motDePasse
     *
     * @param string $motDePasse
     *
     * @return Personne
     */
    public function setMotDePasse($motDePasse)
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    /**
     * Get motDePasse
     *
     * @return string
     */
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Personne
     */
    public function setMail($mail)
    {
        $this->mail = $this->_ENCRYPTE_DATA($mail);;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->_DECRYPTE_DATA($this->mail);
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Personne
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Personne
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $this->_ENCRYPTE_DATA($telephone);

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->_DECRYPTE_DATA($this->telephone);
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Personne
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $this->_ENCRYPTE_DATA($adresse);

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->_DECRYPTE_DATA($this->adresse);
    }

    /**
     * Set boolPermis
     *
     * @param boolean $boolPermis
     *
     * @return Personne
     */
    public function setBoolPermis($boolPermis)
    {
        $this->boolPermis = $boolPermis;

        return $this;
    }

    /**
     * Get boolPermis
     *
     * @return bool
     */
    public function getBoolPermis()
    {
        return $this->boolPermis;
    }

    /**
     * @return bool
     */
    public function isEmprunt()
    {
        return $this->emprunt;
    }

    /**
     * @param bool $emprunt
     */
    public function setEmprunt($emprunt)
    {
        $this->emprunt = $emprunt;
    }

    public function __toString()
    {
        return $this->getPrenom() . " " . $this->getNom();
    }


    private function _ENCRYPTE_DATA($string)
    {
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'SSAGR4';
        $secret_iv = 'coucou';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);

        return base64_encode($output);

    }


    private function _DECRYPTE_DATA($string)
    {
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'SSAGR4';
        $secret_iv = 'coucou';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);


        return openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }


}

