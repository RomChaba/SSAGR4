<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Email(
     *     message = "L' email '{{ value }}' n'est pas valide.",
     *     checkMX = true
     * )
     * @ORM\Column(name="mail", type="string", length=255, unique=true)
     */
    private $mail;

    /**
     * @var bool
     *
     * @ORM\Column(name="isAdmin", type="boolean", nullable=true, options={"default":"0"})
     */
    private $isAdmin=false;

    /**
     * @var string
     *
     * @ORM\Column(name="motDePasse", type="string", length=255)
     */
    private $motDePasse;

    /**
     * @var string
     * @Assert\Length(min=6, minMessage="Le mot de passe doit contenir minimum 6 caractères")
     */
    private $nouveauMotDePasse;

    /**
     * @var string
     * @Assert\Length(min=6, minMessage="Le mot de passe doit contenir minimum 6 caractères")
     */
    private $confirmationMotDePasse;

    /**
     * @Assert\IsTrue(message="Les 2 mots de passe doivent être identique")
     */
    public function isConfirmationMotDePasse()
    {
        if($this->getNouveauMotDePasse() == null)
        {
            return true;
        }

        if($this->getNouveauMotDePasse() == $this->getConfirmationMotDePasse())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @Assert\IsTrue(message="Le format du téléphone n'est pas correct")
     */
    public function isTelephone()
    {
        if( preg_match ( " /^[0-9]{10,12}$/ " , $this->getTelephone() ))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

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
     * @ORM\Column(name="rue", type="string", length=255)
     */
    private $rue;

    /**
     * @var string
     *
     * @ORM\Column(name="cp", type="string", length=255)
     * @Assert\Length(max=5, maxMessage="Le code postal doit faire maximum 5 caractères.")
     * @Assert\Regex(pattern="/^[0-9]+$/", message="Veuillez ne rentrer que des chiffres")
     */
    private $cp;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var bool
     *
     * @ORM\Column(name="permis", type="boolean")
     */
    private $permis=false;

    /**
     * @var bool
     *
     * @ORM\Column(name="actif", type="boolean")
     */
    private $actif;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="Emprunt_Personne",mappedBy="personneId")
     */
    private $listeEmprunt;


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
//        return $this->nom;
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
     * @return bool
     */
    public function isAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
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
     * @return mixed
     */
    public function getNouveauMotDePasse()
    {
        return $this->nouveauMotDePasse;
    }

    /**
     * @param mixed $nouveauMotDePasse
     */
    public function setNouveauMotDePasse($nouveauMotDePasse)
    {
        $this->nouveauMotDePasse = $nouveauMotDePasse;
    }

    /**
     * @return mixed
     */
    public function getConfirmationMotDePasse()
    {
        return $this->confirmationMotDePasse;
    }

    /**
     * @param mixed $confirmationMotDePasse
     */
    public function setConfirmationMotDePasse($confirmationMotDePasse)
    {
        $this->confirmationMotDePasse = $confirmationMotDePasse;
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
     * Set permis
     *
     * @param boolean $permis
     *
     * @return Personne
     */
    public function setPermis($permis)
    {
        $this->permis = $permis;

        return $this;
    }

    /**
     * Get boolPermis
     *
     * @return bool
     */
    public function getPermis()
    {
        return $this->permis;
    }

    /**
     * @return string
     */
    public function getRue()
    {
        return $this->rue;
    }

    /**
     * @param string $rue
     */
    public function setRue($rue)
    {
        $this->rue = $rue;
    }

    /**
     * @return string
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * @param string $cp
     */
    public function setCp($cp)
    {
        $this->cp = $cp;
    }

    /**
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * @return bool
     */
    public function isActif()
    {
        return $this->actif;
    }

    /**
     * @param bool $actif
     */
    public function setActif($actif)
    {
        $this->actif = $actif;
    }

    /**
     * @return DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param DateTime $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
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

    /**
     * @return string
     */
    public function getListeEmprunt()
    {
        return $this->listeEmprunt;
    }

    /**
     * @param string $listeEmprunt
     */
    public function setListeEmprunt($listeEmprunt)
    {
        $this->listeEmprunt = $listeEmprunt;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }



}

