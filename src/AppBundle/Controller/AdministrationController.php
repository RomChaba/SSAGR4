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
    /**
     * @Route("/administration", name="administration")
     */
    public function administrationAction(Request $request)
    {
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
        $personnnes =  Array();
        $voitures =  Array();

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