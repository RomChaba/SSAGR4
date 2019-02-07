<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Emprunt;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Vehicule;

class DemandeController extends Controller
{

    public function DemandeAction()
    {
        return $this->render('Demande/demande.html.twig', array("messageEnregistrement", "OKKKKKKK"
            // ...
        ));
    }

    private $leFormulaire = null;

    private function createFormulaire() {

        $lEmprunt = new Emprunt();

        $this->leFormulaire = $this->createFormBuilder($lEmprunt)
            ->add('idVehicule', EntityType::class, array('class' => Vehicule::class, 'data' => 'libelle', 'required'  => true, 'label' =>'Modèle de véhicule : '))
            ->add('dureeLocation', TextType::class, array('label' =>'Durée de la location : '))
           // ->add('url', 'text', array('max_length' => 50, 'label' =>'SLUG de l'URL : '))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();
        
    }

    /**
     * @Route("/demande", name="Demande")
     */
    public function formAjoutCategAction() {

        $this->createFormulaire(); //On crée le formulaire

        return $this->render('Demande/demande.html.twig', array('formulaireAjout' => $this->leFormulaire->createView())); //On envoie à la vue... une vue générée par le constructeur de formulaire.
    }

}
