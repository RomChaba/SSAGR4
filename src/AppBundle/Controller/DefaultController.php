<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Emprunt;
use AppBundle\Entity\Personne;
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
        $em = $this->getDoctrine()->getManager();

        $test = new DateTime();
        dump($test);

        $listeEmprunt = array();
        if (!isset($_SESSION["liste_Emprunt"])) {
//            $personne1 = new Personne();
//
//            $personne1->setAdresse("rue de la poire");
//            $personne1->setMail("dupont@gmail.com");
//            $personne1->setMotDePasse("mdp1");
//            $personne1->setNom("dupont");
//            $personne1->setPrenom("jean");
//            $personne1->setTelephone("0980473828");
//            $personne1->setBoolPermis(true);
//            $personne1->setPhoto("photoTemp");
//
//            $emp1 = new Emprunt();
//            $emp1->setDateEmprunt($test);
//            $emp1->setNbJourLocation(2);
//            $emp1->setListePersonne($personne1);
//
//            $emp2 = new Emprunt();
//            $emp2->setDateEmprunt($test);
//            $emp2->setNbJourLocation(3);
//            $emp2->setNbJourLocation(3);
//            $emp2->setListePersonne($personne1);
//            $listeEmprunt= [
//                $emp1,
//                $emp2
//            ];

//            $_SESSION["liste_Emprunt"] = $listeEmprunt;
        }else{
            $listeEmprunt = $_SESSION["liste_Emprunt"];

//            array_push($listeEmprunt,$this->get("new_emprunt"));
        }

        dump($listeEmprunt);

//        $listeEmprunt = $em->getRepository('AppBundle:Personne')->findAll();
//        dump($listeEmprunt);

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'listeEmprunt'=> $listeEmprunt
        ]);
    }

}
