<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Emprunt;
use AppBundle\Entity\Emprunt_Personne;
use AppBundle\Entity\Lieu;
use AppBundle\Entity\Lieu_emprunt;
use AppBundle\Entity\Personne;
use AppBundle\Entity\Site;
use AppBundle\Form\LieuType;
use Doctrine\Common\Collections\ArrayCollection;
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
use Symfony\Component\Validator\Constraints\DateTime;

class DemandeController extends Controller
{
    /**
     * @Route("/demande", name="Demande")
     */
    public function DemandeAction(Request $request)
    {
        $pers_co = $request->getSession()->get('userConnect');

        if ($pers_co == null) {
            return $this->redirectToRoute("connexion");
        }

        $personnes = $this->getDoctrine()->getRepository('AppBundle:Personne');
        $lieu = $this->getDoctrine()->getRepository('AppBundle:Lieu');
        $vehicule = $this->getDoctrine()->getRepository('AppBundle:Vehicule');

        $listePersonne = $personnes->findBy(["permis"=>true]);
        $listeLieu = $lieu->findAll();
        $listeVehicule = $vehicule->findAll();


//        date_default_timezone_set('Europe/Paris');
        $dateDuJour = getdate();
//        dump($dateDuJour);


//       ***** Creation du form pour un nouveau lieu *****

        $lieu = new Lieu();


        $form_lieu = $this->createForm(LieuType::class,$lieu);


        return $this->render(
            'Demande/demande.html.twig',
            array(
                "messageEnregistrement" => "OKKKKKKK",
                "pers_co" => $pers_co,
                "listePersonne" => $listePersonne,
                "listeLieu" => $listeLieu,
                "listeVehicule" => $listeVehicule,
                "dateDuJour" => $dateDuJour,
                "form_lieu" => $form_lieu->createView(),
            )
        );
    }

    //Recuperation du formulaire et traitement des infos


    /**
     * @Route("/demandeForm", name="DemandeForm")
     */
    public function DemandeFormAction(Request $request)
    {


        /********* INIT DES REPOSOTORY ********/
        $repoPersonne = $this->getDoctrine()->getRepository("AppBundle:Personne");
        $repoVehicule = $this->getDoctrine()->getRepository("AppBundle:Vehicule");
        $repoLieu = $this->getDoctrine()->getRepository("AppBundle:Lieu");
        $repoEmprunt = $this->getDoctrine()->getRepository("AppBundle:Emprunt");

        //recuperation du conducteur
        /** @var Personne $conducteur */
        $conducteur = $repoPersonne->findOneBy(["id" => $request->get("personne")]);


        //recuperation du vehicule
        /** @var Vehicule $vehicule */
        $vehicule = $repoVehicule->findOneBy(["id" => $request->get("vehicule")]);

        //recuperation du commentaire
        $commentaire = $request->get("commentaire");


        //recuperation du lieu de depart date + h:min
        /** @var Lieu $lieu_depart */
        $lieu_depart = $repoLieu->findOneBy(["id" => $request->get("lieu_depart_1")]);

        $date_tempo = explode("/", $request->get("date_depart_1"));

        $date_depart = new \DateTime();
        $date_depart->setDate($date_tempo[2], $date_tempo[1], $date_tempo[0]);
        $date_depart->setTime($request->get("h_depart_1"), $request->get("min_depart_1"));


        //recuperation du lieu d'arrive date + h:min
        /** @var Lieu $lieu_arrive */
        $lieu_arrive = $repoLieu->findOneBy(["id" => $request->get("lieu_arrive_1")]);

        $date_tempo = explode("/", $request->get("date_arrive_1"));

        $date_arrive = new \DateTime();
        $date_arrive->setDate($date_tempo[2], $date_tempo[1], $date_tempo[0]);
        $date_arrive->setTime($request->get("h_arrive_1"), $request->get("min_arrive_1"));


        // Création de la liste des lieux
        $listeLieu = new ArrayCollection();
        $lieuxEmpruntDepart = new Lieu_emprunt();
        $lieuxEmpruntArriver = new Lieu_emprunt();


        //Creation de l'emprunt et de ses branches
        $emprunt = new Emprunt();
        $emprunt->setId(time());
        $emprunt->setVehiculeId($vehicule);

        $lieuxEmpruntArriver->setEmpruntId($emprunt);
        $lieuxEmpruntArriver->setLieuId($lieu_arrive);
        $lieuxEmpruntArriver->setDepart(false);
        $lieuxEmpruntArriver->setDateEtHeure($date_arrive);

        $lieuxEmpruntDepart->setDateEtHeure($date_depart);
        $lieuxEmpruntDepart->setEmpruntId($emprunt);
        $lieuxEmpruntDepart->setLieuId($lieu_depart);
        $lieuxEmpruntDepart->setDepart(true);

        //Ajout des lieux de l'aller dans la liste
        $listeLieu->add($lieuxEmpruntDepart);
        $listeLieu->add($lieuxEmpruntArriver);
        $emprunt->setListeLieux($listeLieu);

        $emprunt->setCommentaire($commentaire);

        //Création de la liste des personnes pour l'emprunt
        $listePersonne = new ArrayCollection();

        $empruntPerosnne = new Emprunt_Personne();
        $empruntPerosnne->setPersonneId($conducteur);
        $empruntPerosnne->setEmpruntId($emprunt);
        $empruntPerosnne->setConducteur(true);

//        $em = $this->getDoctrine()->getManager();
//        $em->persist($empruntPerosnne);
//        $em->flush();


        // Ajout du conducteur
        $listePersonne->add($empruntPerosnne);
        $emprunt->setListePersonne($listePersonne);


        //Création de la liaison entre l'emprunt et les lieux
        $liste_lieux_new = array();

        array_push($liste_lieux_new, $lieuxEmpruntDepart);

        array_push($liste_lieux_new, $lieuxEmpruntArriver);

        //Save de l'emprunt
        $em = $this->getDoctrine()->getManager();

        $em->persist($emprunt);
        $em->flush();

//    Test si aller retour a ete coche
        if ($request->get("aller_ret") == "on") {
        //  Recupertation des dates 1 pour le retour

            $date_tempo = explode("/", $request->get("date_depart_2"));
            $lieu_retour_dep = new \DateTime();
            $lieu_retour_dep->setDate($date_tempo[2], $date_tempo[1], $date_tempo[0]);
            $lieu_retour_dep->setTime($request->get("h_depart_2"), $request->get("min_depart_2"));
        // Recupertation des dates 2 pour le retour
            $date_tempo = explode("/", $request->get("date_arrive_2"));
            $lieu_retour_arr = new \DateTime();
            $lieu_retour_arr->setDate($date_tempo[2], $date_tempo[1], $date_tempo[0]);
            $lieu_retour_arr->setTime($request->get("h_arrive_2"), $request->get("min_arrive_2"));
        // Création de la liste des lieux
            $listeLieu_ret = new ArrayCollection();
            $lieuxEmpruntDepart_ret = new Lieu_emprunt();
            $lieuxEmpruntArriver_ret = new Lieu_emprunt();
        // Inversion des lieux de depart et d'arrive
            $lieuxEmpruntDepart_ret->setLieuId($lieuxEmpruntArriver->getLieuId());
            $lieuxEmpruntArriver_ret->setLieuId($lieuxEmpruntDepart->getLieuId());
        // Modification des heures
            $lieuxEmpruntDepart_ret->setDateEtHeure($lieu_retour_dep);
            $lieuxEmpruntArriver_ret->setDateEtHeure($lieu_retour_arr);
        // Definition du lieux de depart
            $lieuxEmpruntDepart_ret->setDepart(true);
            $lieuxEmpruntArriver_ret->setDepart(false);
        // Creation du nouvel emprunt
            $emprunt_ret = new Emprunt();
            $emprunt_ret->setId(time());
            $emprunt_ret->setVehiculeId($vehicule);
        // Modification de l'id par le nouvel id
            $lieuxEmpruntDepart_ret->setEmpruntId($emprunt_ret);
            $lieuxEmpruntArriver_ret->setEmpruntId($emprunt_ret);

        // Creation de la liste des lieux
            $listeLieu_ret->add($lieuxEmpruntDepart_ret);
            $listeLieu_ret->add($lieuxEmpruntArriver_ret);
            $emprunt_ret->setListeLieux($listeLieu_ret);
        //Création de la liste des personnes pour l'emprunt
            $listePersonne_ret = new ArrayCollection();

            $empruntPerosnne_ret = new Emprunt_Personne();
            $empruntPerosnne_ret->setPersonneId($conducteur);
            $empruntPerosnne_ret->setEmpruntId($emprunt_ret);
            $empruntPerosnne_ret->setConducteur(true);

        // Ajout du conducteur
            $listePersonne_ret->add($empruntPerosnne_ret);
            $emprunt_ret->setListePersonne($listePersonne_ret);
        // Ajout du commentaire
            $emprunt_ret->setCommentaire($commentaire);

        // Save de l'emprunt
            $em = $this->getDoctrine()->getManager();

            $em->persist($emprunt_ret);
            $em->flush();
        }

        return $this->redirectToRoute("homepage");

    }


    private $leFormulaire = null;

    private function createFormulaire(Emprunt $lEmprunt)
    {


//        $this->leFormulaire = $this->createFormBuilder($lEmprunt)
        $this->leFormulaire = $this->createFormBuilder($lEmprunt)
            // ->add('url', 'text', array('max_length' => 50, 'label' =>'SLUG de l'URL : '))
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
            ->add(
                'vehicule_id',
                EntityType::class,
                array(
                    'class' => Vehicule::class,
                    'data' => 'libelle',
                    'required' => true,
                    'label' => 'Modèle de véhicule : '
                )
            )
//            ->add(
//                null,
//                EntityType::class,
//                array(
//                    'class' => Lieu::class,
//                    'data' => 'libelle',
//                    'required' => true,
//                    'label' => 'Départ : '
//                )
//            )
//            ->add(
//                'dateEmprunt',
//                DateTimeType::class,
//                array(
//                    'label' => 'Date de la location : ',
//                    'years' => range(date('Y'), date('Y') + 6),
//                    'data' => new \DateTime(),
//                    'placeholder' => [
//                        'day' => 'Jour', 'month' => 'Mois','year' => 'Année',
//                        'hour' => 'Heure', 'minute' => 'Minute'
//                    ],
//                )
//            )
//            ->add('nbJourLocation', IntegerType::class, array('label' => 'Nombre de jours : '))

//            ->add(
//                'idSiteArrivee',
//                EntityType::class,
//                array(
//                    'class' => Lieu::class,
//                    'data' => 'libelle',
//                    'required' => true,
//                    'label' => 'Arrivée : '
//                )
//            )
//            ->add(
//                'newSite',
//                ButtonType::class,
//                array(
//                    'attr' => [
//                        'class' => 'save btn btn-success'
//                    ],
//                    'label' => "Nouveau site"
//                )
//            )
            ->add('Enregistrer', SubmitType::class)
            ->getForm();

    }


    public function formAjoutCategAction(Request $request)
    {
        $lEmprunt = new Emprunt();
        $this->createFormulaire($lEmprunt); //On crée le formulaire

//      Partie gestion du formulaire
        $this->leFormulaire->handleRequest($request);

        if ($this->leFormulaire->isSubmitted() && $this->leFormulaire->isValid()) {
//            dump($lEmprunt);
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($lEmprunt);
//            $em->flush();
            if (!isset($_SESSION["liste_Emprunt"])) {
                $_SESSION["liste_Emprunt"] = [$lEmprunt];
            } else {
                array_push($_SESSION["liste_Emprunt"], $lEmprunt);
            }
            return $this->redirectToRoute("homepage");
        }

        return $this->render('Demande/demande.html.twig', array('formulaireAjout' => $this->leFormulaire->createView())); //On envoie à la vue... une vue générée par le constructeur de formulaire.
    }

}
