<?php
/**
 * Created by PhpStorm.
 * User: gvecoven
 * Date: 04/04/2019
 * Time: 15:09
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Emprunt;
use AppBundle\Entity\Emprunt_Personne;
use AppBundle\Entity\Lieu_emprunt;
use AppBundle\Entity\LigneEmprunt;
use AppBundle\Entity\Personne;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdministrationController extends Controller
{
    //private  $personnnes =  Array();
    //private  $voitures;
    /**
     * @Route("/administration", name="administration")
     */
    public function administrationAction(Request $request)
    {
        $pers_co = $request->getSession()->get('userConnect');

        $personnesRepo = $this->getDoctrine()->getRepository('AppBundle:Personne');
        $voituresRepo = $this->getDoctrine()->getRepository('AppBundle:Vehicule');
        $empruntRepo = $this->getDoctrine()->getRepository('AppBundle:Emprunt');

        $personnnes = $personnesRepo->findAll();
        $voitures = $voituresRepo->findAll();
        $emprunts = $empruntRepo->findAll();

        $listeLigneEmprunt = $this->construireLigneEmprunt($emprunts);

        $listeEmpruntJson = array();

        foreach ($emprunts as $emprunt) {
            $listeEmpruntJson[] = $emprunt->empruntForCalendar();
        }
        return $this->render(
            'Administration/administration.html.twig',
            array(
                'personnes' => $personnnes,
                'voitures' => $voitures,
                'emprunts' => $listeLigneEmprunt,
                'empruntsJson' => json_encode($listeEmpruntJson)
            )
        );
    }

    /**
     * @Route("/creationVoiture", name="creationVoiture")
     */
    public function creationVoitureAction(Request $request)
    {
        $pers_co = $request->getSession()->get('userConnect');

        $personnnes =  Array();
        $voitures =  Array();

        return $this->render('Administration/administration.html.twig', array('personnes' => $personnnes, 'voitures' => $voitures));
    }

    /**
     * @Route("/suppressionpersonne/{id}", name="suppressionpersonne")
     */
    public function suppressionPersonneAction(Request $request, int $id)
    {
        $personnesRepo = $this->getDoctrine()->getRepository('AppBundle:Personne');
        $voituresRepo = $this->getDoctrine()->getRepository('AppBundle:Vehicule');
        $empruntRepo = $this->getDoctrine()->getRepository('AppBundle:Emprunt');

        $personneAsupprmier = $personnesRepo->findOneById($id);

        $this->getDoctrine()->getManager()->remove($personneAsupprmier);
        $this->getDoctrine()->getManager()->flush();
        $personnnes = $personnesRepo->findAll();
        $voitures = $voituresRepo->findAll();
        $emprunts = $empruntRepo->findAll();
        $listeLigneEmprunt = $this->construireLigneEmprunt($emprunts);

        return $this->render('Administration/administration.html.twig', array('personnes' => $personnnes, 'voitures' => $voitures, 'emprunts' => $listeLigneEmprunt));
    }

    /**
     * @Route("/suppressionvoiture/{id}", name="suppressionvoiture")
     */
    public function suppressionVoitureAction(Request $request, int $id)
    {
        $personnesRepo = $this->getDoctrine()->getRepository('AppBundle:Personne');
        $voituresRepo = $this->getDoctrine()->getRepository('AppBundle:Vehicule');
        $empruntRepo = $this->getDoctrine()->getRepository('AppBundle:Emprunt');

        $voitureAsupprmier = $voituresRepo->findOneById($id);

        $this->getDoctrine()->getManager()->remove($voitureAsupprmier);
        $this->getDoctrine()->getManager()->flush();
        $personnnes = $personnesRepo->findAll();
        $voitures = $voituresRepo->findAll();
        $emprunts = $empruntRepo->findAll();
        $listeLigneEmprunt = $this->construireLigneEmprunt($emprunts);

        return $this->render('Administration/administration.html.twig', array('personnes' => $personnnes, 'voitures' => $voitures, 'emprunts' => $listeLigneEmprunt));
    }

    /**
     * @Route("/suppressionemprunt/{id}", name="suppressionemprunt")
     */
    public function suppressionEmpruntAction(Request $request, int $id)
    {
        $personnesRepo = $this->getDoctrine()->getRepository('AppBundle:Personne');
        $voituresRepo = $this->getDoctrine()->getRepository('AppBundle:Vehicule');
        $empruntRepo = $this->getDoctrine()->getRepository('AppBundle:Emprunt');

        $empruntAsupprmier = $empruntRepo->findOneById($id);

        $this->getDoctrine()->getManager()->remove($empruntAsupprmier);
        $this->getDoctrine()->getManager()->flush();
        $personnnes = $personnesRepo->findAll();
        $voitures = $voituresRepo->findAll();
        $emprunts = $empruntRepo->findAll();
        $listeLigneEmprunt = $this->construireLigneEmprunt($emprunts);

        return $this->render('Administration/administration.html.twig', array('personnes' => $personnnes, 'voitures' => $voitures, 'emprunts' => $listeLigneEmprunt));
    }


    /**
     * @Route("/creationPersonne", name="creationPersonne")
     */
    public function creationPersonneAction(Request $request)
    {
        $personnnes =  Array();
        $voitures =  Array();

        return $this->render('Administration/administration.html.twig', array('personnes' => $personnnes, 'voitures' => $voitures));
    }

    private function construireLigneEmprunt(array $emprunts)
    {
        $personnesRepo = $this->getDoctrine()->getRepository('AppBundle:Personne');
        $listeLigneEmprunt = new ArrayCollection();

        /** @var Emprunt $emprunt */
        foreach ($emprunts as $emprunt  ) {
            $ligneEmprunt = new LigneEmprunt();
            $ligneEmprunt->setIdEmprunt($emprunt->getId());
            $personnesEmprunt = $emprunt->getListePersonne();
            $lieusEmprunt = $emprunt->getListeLieux();
            $conducteur = new Personne();

            /** @var Emprunt_Personne $emprunt_personne */
            foreach ($personnesEmprunt as $emprunt_personne) {
                if ($emprunt_personne->getConducteur()) {
                    $conducteur = $personnesRepo->findOneBy(['id' => $emprunt_personne->getPersonneId()]);
                }
            }

            $ligneEmprunt->setConducteurName($conducteur->getPrenom() . " " . $conducteur->getNom());

            $lieuEmpruntDepart = new Lieu_emprunt();
            $lieuEmpruntArriver = new Lieu_emprunt();

            /** @var Lieu_emprunt $lieuEmprunt */
            foreach ($lieusEmprunt as $lieuEmprunt) {
                if ($lieuEmprunt->getDepart()) {
                    $lieuEmpruntDepart = $lieuEmprunt;
                } else {
                    $lieuEmpruntArriver = $lieuEmprunt;
                }
            }

            $lieuArriver = $lieuEmpruntArriver->getLieuId();
            $lieuDepart = $lieuEmpruntDepart->getLieuId();

            $ligneEmprunt->setLieu_Arriver($lieuArriver->getLibelle());
            $ligneEmprunt->setLieu_Depart($lieuDepart->getLibelle());
            $ligneEmprunt->setDate_Depart($lieuEmpruntDepart->getDateEtHeure()->format('d-m-Y'));
            $ligneEmprunt->setDate_Arriver($lieuEmpruntArriver->getDateEtHeure()->format('d-m-Y'));

            $listeLigneEmprunt->Add($ligneEmprunt);
        }

        return $listeLigneEmprunt;
    }
}