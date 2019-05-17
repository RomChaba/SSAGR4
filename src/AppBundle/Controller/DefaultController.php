<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Emprunt;
use AppBundle\Entity\Personne;
use AppBundle\Entity\Vehicule;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{






    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $pers_co = $request->getSession()->get('userConnect');

        if ($pers_co == null) {
            return $this->redirectToRoute("connexion");
        }

        //$pers_co = $repoPersonne->findOneById(11);

        $em = $this->getDoctrine()->getManager();

        $test = new DateTime();

        $listeEmprunt = $request->getSession()->get("EMPRUNT");
        $lieu_emprunt = $request->getSession()->get("LIEU_EMPRUNT");


        $listeLieu = $em->getRepository('AppBundle:Lieu')->findAll();

        //Recuperation de la liste des villes



        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'listeEmprunt'=> $listeEmprunt,
            'lieu_emprunt'=> $lieu_emprunt,
            'listeLieu'=> $listeLieu,
            'pers_co'=> $pers_co,
        ]);
    }

}
