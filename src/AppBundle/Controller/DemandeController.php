<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Emprunt;
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

        $personnes = $this->getDoctrine()->getRepository('AppBundle:Personne');
        $lieu = $this->getDoctrine()->getRepository('AppBundle:Lieu');
        $vehicule = $this->getDoctrine()->getRepository('AppBundle:Vehicule');

        $listePersonne = $personnes->findAll();
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

        //Ajout des lieux de l'aller dans la liste
        $listeLieu->add($lieu_depart);
        $listeLieu->add($lieu_arrive);

        //Création de la liste des personnes pour l'emprunt
        $listePersonne = new ArrayCollection();
        // Ajout du conducteur
        $listePersonne->add($conducteur);


        //Creation de l'emprunt et de ses branches
        $emprunt = new Emprunt();
        $emprunt->setId(time());
        $emprunt->setVehiculeId($vehicule);
        $emprunt->setListeLieux($listeLieu);
        $emprunt->setListePersonne($listePersonne);
        $emprunt->setCommentaire($commentaire);

        //Création de la liaison entre l'emprunt et les lieux
        $liste_lieux_new = array();

        $lieu_emprunt_dep = new Lieu_emprunt();
        $lieu_emprunt_ari = new Lieu_emprunt();

        $lieu_emprunt_dep->setEmpruntId($emprunt->getId());
        $lieu_emprunt_dep->setDateEtHeure($date_depart);
        $lieu_emprunt_dep->setLieuId($lieu_depart->getId());
        $lieu_emprunt_dep->setDepart(true);

        array_push($liste_lieux_new, $lieu_emprunt_dep);

        $lieu_emprunt_ari->setEmpruntId($emprunt->getId());
        $lieu_emprunt_ari->setDateEtHeure($date_arrive);
        $lieu_emprunt_ari->setLieuId($lieu_arrive->getId());
        $lieu_emprunt_ari->setDepart(false);

        array_push($liste_lieux_new, $lieu_emprunt_ari);

        //Récupération de la liste des emprunts existant
        //TODO ENLEVER ET REMPLACER
        if ($request->getSession()->get("EMPRUNT") == null) {
            $request->getSession()->set("EMPRUNT", array());
        }
        if ($request->getSession()->get("LIEU_EMPRUNT") == null) {
            $request->getSession()->set("LIEU_EMPRUNT", array());
        }

        /** @var array $liste_emprunt */
        $liste_emprunt = $request->getSession()->get("EMPRUNT");


//    Test si aller retour a ete coche
        if ($request->get("aller_ret") == "on") {

//            inversion des lieux de depart et d'arrive

            $old_depart = $lieu_depart;
            $lieu_depart = $lieu_arrive;
            $lieu_arrive = $old_depart;

            // Création de la liste des lieux
            $listeLieu = new ArrayCollection();

            //Ajout des lieux de l'aller dans la liste
            $listeLieu->add($lieu_depart);
            $listeLieu->add($lieu_arrive);

            //            Creation du nouvel emprunt
            $emprunt_ret = new Emprunt();
            $emprunt_ret->setId(time() + 1);
            $emprunt_ret->setVehiculeId($vehicule);
            $emprunt_ret->setListeLieux($listeLieu);
            $emprunt_ret->setListePersonne($listePersonne);
            $emprunt_ret->setCommentaire($commentaire);
            array_push($liste_emprunt, $emprunt_ret);


//            Recupertation des dates 1 pour le retour
            $date_tempo = explode("/", $request->get("date_depart_2"));
            $date_depart = new \DateTime();
            $date_depart->setDate($date_tempo[2], $date_tempo[1], $date_tempo[0]);
            $date_depart->setTime($request->get("h_depart_2"), $request->get("min_depart_2"));


//            Recupertation des dates 2 pour le retour

            $date_tempo = explode("/", $request->get("date_arrive_1"));
            $date_arrive = new \DateTime();
            $date_arrive->setDate($date_tempo[2], $date_tempo[1], $date_tempo[0]);
            $date_arrive->setTime($request->get("h_arrive_2"), $request->get("min_arrive_2"));

            $lieu_emprunt_dep = new Lieu_emprunt();
            $lieu_emprunt_dep->setEmpruntId($emprunt_ret->getId());
            $lieu_emprunt_dep->setDateEtHeure($date_depart);
            $lieu_emprunt_dep->setLieuId($lieu_depart->getId());
            $lieu_emprunt_dep->setDepart(true);

            array_push($liste_lieux_new, $lieu_emprunt_dep);


            dump($request->get("lieu_arrive_2"));

            $lieu_emprunt_ari = new Lieu_emprunt();
            $lieu_emprunt_ari->setEmpruntId($emprunt_ret->getId());
            $lieu_emprunt_ari->setDateEtHeure($date_arrive);
            $lieu_emprunt_ari->setLieuId($lieu_arrive->getId());
            $lieu_emprunt_ari->setDepart(false);

            array_push($liste_lieux_new, $lieu_emprunt_ari);


        }


        $liste_lieux = $request->getSession()->get("LIEU_EMPRUNT");
        $liste_lieux = array_merge($liste_lieux, $liste_lieux_new);

        $request->getSession()->set("LIEU_EMPRUNT", $liste_lieux);


        array_push($liste_emprunt, $emprunt);
        $request->getSession()->set("EMPRUNT", $liste_emprunt);

//        $em = $this->getDoctrine()->getManager();

//        $em->persist($emprunt);
//        $em->flush();
//
//        die();
//        $lieu_emprunt_dep = new Lieu_emprunt();
//        $lieu_emprunt_dep->setEmpruntId($emprunt->getId());
//        $lieu_emprunt_dep->setDepart(true);
//        $lieu_emprunt_dep->setEmpruntId(true);
//        $lieu_emprunt_dep->setLieuId($lieu_depart->getId());
//        $lieu_emprunt_dep->setDateEtHeure($date_depart);


//        dump($request);
//        die();

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
            dump($lEmprunt);
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
