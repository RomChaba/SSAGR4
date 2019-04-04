<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Emprunt;
use AppBundle\Entity\Lieu;
use AppBundle\Entity\Lieu_emprunt;
use AppBundle\Entity\Personne;
use AppBundle\Entity\Site;
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
    public function DemandeAction()
    {

        $pers_co = new Personne();
        $pers_co->setId(1);
        $pers_co->setPrenom("Marc");
        $pers_co->setNom("Dupont");
        $pers_co->setPermis(true);


        $personnes = $this->getDoctrine()->getRepository('AppBundle:Personne');
        $lieu = $this->getDoctrine()->getRepository('AppBundle:Lieu');
        $vehicule = $this->getDoctrine()->getRepository('AppBundle:Vehicule');

        $listePersonne = $personnes->findAll();
        $listeLieu = $lieu->findAll();
        $listeVehicule = $vehicule->findAll();


        date_default_timezone_set('Europe/Paris');
        $dateDuJour = getdate();
        dump($dateDuJour);

        return $this->render(
            'Demande/demande.html.twig',
            array(
                "messageEnregistrement"=>"OKKKKKKK",
                "pers_co"=>$pers_co,
                "listePersonne"=>$listePersonne,
                "listeLieu"=>$listeLieu,
                "listeVehicule"=>$listeVehicule,
                "dateDuJour"=>$dateDuJour,
            )
        );
    }

    //Recuperation du formulaire et traitement des infos


    /**
     * @Route("/demandeForm", name="DemandeForm")
     */
    public function DemandeFormAction(Request $request)
    {
        //exemple
        /*
          "name" => "2"
          "lieu_depart_1" => "1"
          "date_depart_1" => "04/04/2019"
          "h_depart_1" => "10"
          "min_depart_1" => "42"
          "lieu_arrive_1" => "2"
          "date_arrive_1" => "25/04/2019"
          "h_arrive_1" => "6"
          "min_arrive_1" => "5"
          "vehicule" => "2"
          "h_depart_2" => "10"
          "min_depart_2" => "48"
          "h_arrive_2" => "14"
          "min_arrive_2" => "15"
          "commentaire" => "azertyuiop"

         */

        //recuperation du conducteur
        $repoPersonne = $this->getDoctrine()->getRepository("AppBundle:Personne");

        /** @var Personne $conducteur */
        $conducteur = $repoPersonne->findOneBy(["id"=>$request->get("personne")]);


        dump($conducteur);
        //recuperation du vehicule
        $repoVehicule = $this->getDoctrine()->getRepository("AppBundle:Vehicule");
        /** @var Vehicule $vehicule */
        $vehicule = $repoVehicule->findOneBy(["id"=>$request->get("vehicule")]);

        dump($vehicule);
        //recuperation du commentaire
        $commentaire = $request->get("commentaire");

        dump($commentaire);
        //recuperation du lieu de depart date + h:min
        $repoLieu = $this->getDoctrine()->getRepository("AppBundle:Lieu");
        /** @var Lieu $lieu_depart */
        $lieu_depart = $repoLieu->findOneBy(["id"=>$request->get("lieu_depart_1")]);

        $date_tempo = explode("/",$request->get("date_depart_1"));

        $date_depart = new \DateTime();
        $date_depart->setDate($date_tempo[2],$date_tempo[1],$date_tempo[0]);
        $date_depart->setTime($request->get("h_depart_1"),$request->get("min_depart_1"));

        dump($lieu_depart);
        dump($date_depart);


        //recuperation du lieu d'arrive date + h:min
        /** @var Lieu $lieu_arrive */
        $lieu_arrive = $repoLieu->findOneBy(["id"=>$request->get("lieu_arrive_1")]);

        $date_tempo = explode("/",$request->get("date_arrive_1"));

        $date_arrive = new \DateTime();
        $date_arrive->setDate($date_tempo[2],$date_tempo[1],$date_tempo[0]);
        $date_arrive->setTime($request->get("h_arrive_1"),$request->get("min_arrive_1"));

        dump($lieu_arrive);
        dump($date_arrive);


        $listeLieu = new ArrayCollection();
        $listeLieu->add($lieu_depart);
        $listeLieu->add($lieu_arrive);

        $listePersonne = new ArrayCollection();
        $listePersonne->add($conducteur);


        //Creation de l'emprunt et de ses branches
        $emprunt = new Emprunt();
        $emprunt->setId(rand());
        $emprunt->setVehiculeId($vehicule);
        $emprunt->setListeLieux($listeLieu);
        $emprunt->setListePersonne($listePersonne);
        $emprunt->setCommentaire($commentaire);

        dump($emprunt);

        //Création de la liaison entre l'emprunt et les lieux

        $liste_lieux = array();

        $lieu_emprunt_dep = new Lieu_emprunt();
        $lieu_emprunt_ari = new Lieu_emprunt();

        $lieu_emprunt_dep->setEmpruntId($emprunt->getId());
        $lieu_emprunt_dep->setDateEtHeure($date_depart);
        $lieu_emprunt_dep->setLieuId($lieu_depart->getId());
        $lieu_emprunt_dep->setDepart(true);

        array_push($liste_lieux,$lieu_emprunt_dep);

        $lieu_emprunt_ari->setEmpruntId($emprunt->getId());
        $lieu_emprunt_ari->setDateEtHeure($date_arrive);
        $lieu_emprunt_ari->setLieuId($lieu_arrive->getId());
        $lieu_emprunt_ari->setDepart(false);

        array_push($liste_lieux,$lieu_emprunt_ari);


        //TODO ENLEVER ET REMPLACER
        if ($request->getSession()->get("EMPRUNT") == null) {
            $request->getSession()->set("EMPRUNT",array());
        }
        if ($request->getSession()->get("LIEU_EMPRUNT") == null) {
            $request->getSession()->set("LIEU_EMPRUNT",array());
        }
        /** @var array $liste_emprunt */
        $liste_emprunt = $request->getSession()->get("EMPRUNT");
        array_push($liste_emprunt,$emprunt);
        $request->getSession()->set("EMPRUNT",$liste_emprunt);
        $request->getSession()->set("LIEU_EMPRUNT",$liste_lieux);

        $em = $this->getDoctrine()->getManager();

//        $em->persist($emprunt);
//        $em->flush();

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
