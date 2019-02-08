<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Emprunt;
use AppBundle\Entity\Personne;
use AppBundle\Entity\Site;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Vehicule;
use Symfony\Component\HttpFoundation\Request;

class DemandeController extends Controller
{

    public function DemandeAction()
    {
        return $this->render('Demande/demande.html.twig', array("messageEnregistrement", "OKKKKKKK"
            // ...
        ));
    }

    private $leFormulaire = null;

    private function createFormulaire(Emprunt $lEmprunt)
    {


        $this->leFormulaire = $this->createFormBuilder($lEmprunt)
            // ->add('url', 'text', array('max_length' => 50, 'label' =>'SLUG de l'URL : '))
            ->add(
                'idVehicule',
                EntityType::class,
                array(
                    'class' => Vehicule::class,
                    'data' => 'libelle',
                    'required' => true,
                    'label' => 'Modèle de véhicule : '
                )
            )
            ->add(
                'listepersonne',
                EntityType::class,
                array(
                    'class' => Personne::class,
                    'data' => 'nom',
                    'required' => true,
                    'label' => 'Conducteur : '
                )
            )
            ->add('dateEmprunt', DateTimeType::class, array('label' => 'Date de la location : '))
            ->add('nbJourLocation', IntegerType::class, array('label' => 'Nombre de jours : '))
            ->add(
                'idSite',
                EntityType::class,
                array(
                    'class' => Site::class,
                    'data' => 'libelle',
                    'required' => true,
                    'label' => 'Site : '
                )
            )
            ->add(
                'newSite',
                ButtonType::class,
                array(
                    'attr' => [
                        'class' => 'save btn btn-success'
                    ],
                    'label' => "Nouveau site"
                )
            )
            ->add('Enregistrer', SubmitType::class)
            ->getForm();

    }

    /**
     * @Route("/demande", name="Demande")
     */
    public function formAjoutCategAction(Request $request)
    {
        $lEmprunt = new Emprunt();
        $this->createFormulaire($lEmprunt); //On crée le formulaire

//      Partie gestion du formulaire
        $this->leFormulaire->handleRequest($request);

        if ($this->leFormulaire->isSubmitted() && $this->leFormulaire->isValid()) {
            dump($lEmprunt);
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($lEmprunt);
//            $em->flush();
            array_push($_SESSION["liste_Emprunt"],$lEmprunt);
            return $this->redirectToRoute("homepage");
        }

        return $this->render('Demande/demande.html.twig', array('formulaireAjout' => $this->leFormulaire->createView())); //On envoie à la vue... une vue générée par le constructeur de formulaire.
    }

}
