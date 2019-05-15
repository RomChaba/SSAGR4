<?php
/**
 * Created by PhpStorm.
 * User: gvecoven
 * Date: 04/04/2019
 * Time: 15:09
 */

namespace AppBundle\Controller;


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

        $personnnes = $personnesRepo->findAll();
        $voitures = $voituresRepo->findAll();

        return $this->render('Administration/administration.html.twig', array('personnes' => $personnnes, 'voitures' => $voitures));
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

        $personneAsupprmier = $personnesRepo->findOneById($id);

        $this->getDoctrine()->getManager()->remove($personneAsupprmier);
        $this->getDoctrine()->getManager()->flush();
        $personnnes = $personnesRepo->findAll();
        $voitures = $voituresRepo->findAll();

        return $this->render('Administration/administration.html.twig', array('personnes' => $personnnes, 'voitures' => $voitures));
    }

    /**
     * @Route("/suppressionvoiture/{id}", name="suppressionvoiture")
     */
    public function suppressionVoitureAction(Request $request, int $id)
    {
        $personnesRepo = $this->getDoctrine()->getRepository('AppBundle:Personne');
        $voituresRepo = $this->getDoctrine()->getRepository('AppBundle:Vehicule');

        $voitureAsupprmier = $voituresRepo->findOneById($id);

        $this->getDoctrine()->getManager()->remove($voitureAsupprmier);
        $this->getDoctrine()->getManager()->flush();
        $personnnes = $personnesRepo->findAll();
        $voitures = $voituresRepo->findAll();

        return $this->render('Administration/administration.html.twig', array('personnes' => $personnnes, 'voitures' => $voitures));
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
}