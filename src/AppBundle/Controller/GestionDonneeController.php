<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cle;
use AppBundle\Entity\Emprunt;
use AppBundle\Entity\Localisation_Cle;
use AppBundle\Entity\Personne;
use AppBundle\Entity\Rdv;
use AppBundle\Entity\Site;
use AppBundle\Entity\Vehicule;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class GestionDonneeController extends Controller
{

    /**
     * @param Request $request
     */
    public function initialiserBaseDeDonneeAction(Request $request)
    {
        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        $this->addVehicule($em);

        $this->addPersonne($em);

        $this->addSite($em);

        //$this->addCle($em);

        //$this->addEmprunt($em);

        //$this->addRdv($em);

        //$this->addLocalisationCle($em);

        // Étape 2 : On « flush » tout ce qui a été persisté avant
        $em->flush();

        return new Response("La base de données à été réinitialiser !");
    }

    private function addPersonne (EntityManager $em)
    {
        $repository = $em->getRepository('AppBundle:Personne');
        $repository->deleteAllPersonne();

        $personne1 = new Personne();

        $personne1->setAdresse("rue de la poire");
        $personne1->setMail("dupont@gmail.com");
        $personne1->setMotDePasse("mdp1");
        $personne1->setNom("dupont");
        $personne1->setPrenom("jean");
        $personne1->setTelephone("0980473828");
        $personne1->setBoolPermis(true);
        $personne1->setPhoto("photoTemp");

        // Étape 1 : On « persiste » l'entité
        $em->persist($personne1);

        $personne2= new Personne();

        $personne2->setAdresse("rue de tartenpion");
        $personne2->setMail("partula@gmail.com");
        $personne2->setMotDePasse("mdp1");
        $personne2->setNom("partula");
        $personne2->setPrenom("marie");
        $personne2->setTelephone("0980984206");
        $personne2->setBoolPermis(true);
        $personne2->setPhoto("photoTemp");

        // Étape 1 : On « persiste » l'entité
        $em->persist($personne2);

        $personne3 = new Personne();

        $personne3->setAdresse("rue de la manche");
        $personne3->setMail("bernard@gmail.com");
        $personne3->setMotDePasse("mdp1");
        $personne3->setNom("et-bianca");
        $personne3->setPrenom("bernard");
        $personne3->setTelephone("0980476436");
        $personne3->setBoolPermis(false);
        $personne3->setPhoto("photoTemp");

        // Étape 1 : On « persiste » l'entité
        $em->persist($personne3);
    }

    private function addVehicule( EntityManager $em)
    {
        $repository = $em->getRepository('AppBundle:Vehicule');
        $repository->deleteAllVehicule();

        $vehicule1 = new Vehicule();

        $vehicule1->setCouleur("noir");
        $vehicule1->setLibelle("Golf4");


        // Étape 1 : On « persiste » l'entité
        $em->persist($vehicule1);

        $vehicule2 = new Vehicule();

        $vehicule2->setCouleur("rouge");
        $vehicule2->setLibelle("208");


        // Étape 1 : On « persiste » l'entité
        $em->persist($vehicule2);

        $vehicule3 = new Vehicule();

        $vehicule3->setCouleur("blanc");
        $vehicule3->setLibelle("Clio");


        // Étape 1 : On « persiste » l'entité
        $em->persist($vehicule3);
    }

    private function addSite(EntityManager $em)
    {
        $repository = $em->getRepository('AppBundle:Site');
        $repository->deleteAllSite();

        $site1 = new Site();

        $site1->setLibelle("ENI-StHerblain");
        $site1->setBoolSiteOfficiel(true);
        $site1->setCoordGPS("47.2267535,-1.6230988");

        $em->persist($site1);

        $site2 = new Site();

        $site2->setLibelle("ENI-Rennes");
        $site2->setBoolSiteOfficiel(true);
        $site2->setCoordGPS("48.038925,-1.6945811");

        $em->persist($site2);

        $site3 = new Site();

        $site3->setLibelle("Bordeaux");
        $site3->setBoolSiteOfficiel(false);
        $site3->setCoordGPS("44.8638282,-0.6561815");

        $em->persist($site3);
    }

    private function addEmprunt (EntityManager $em)
    {
        $repository = $em->getRepository('AppBundle:Emprunt');
        $repository->deleteAllEmprunt();

        $emprunt1 = new Emprunt();

        $emprunt1->setDateEmprunt(getdate());
        $emprunt1->setDureeLocation("2");
        //$emprunt1->
        $em->persist($emprunt1);
    }

    private function addCle (EntityManager $em)
    {
        $repository = $em->getRepository('AppBundle:Cle');
        $repository->deleteAllCle();

        $cle1 = new Cle();

        $em->persist($cle1);
    }

    private function addRdv (EntityManager $em)
    {
        $repository = $em->getRepository('AppBundle:Rdv');
        $repository->deleteAllRdv();

        $rdv1 = new Rdv();

        $em->persist($rdv1);
    }

    private function addLocalisationCle (EntityManager $em)
    {
        $repository = $em->getRepository('AppBundle:LocalisationCle');
        $repository->deleteAllLocalisationCle();

        $localisationCle = new Localisation_Cle();

        $localisationCle ->setCommentaire("Cle une");

        $em->persist($localisationCle);
    }
}
