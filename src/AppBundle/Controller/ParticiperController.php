<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Emprunt;
use AppBundle\Entity\Personne;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Validator\Constraints\DateTime;
class ParticiperController extends Controller
{
    /**
     * @Route("/participer", name="participer")
     */
    public function chargementParticiperAction(Request $request)
    {
       // $em = $this->getDoctrine()->getManager();

        $listeEmprunt = $_SESSION["liste_Emprunt"];

        // replace this example code with whatever you need
        return $this->render('participer/participer.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'listeEmprunt'=> $listeEmprunt
        ]);
    }

    /**
     * @Route("/participer2", name="clickparticiper")
     */
    public function clickParticiperAction(Request $request, $emprunt)
    {
        $listeEmprunt = $_SESSION["liste_Emprunt"];
        $listeEmpruntPersonne = $_SESSION["liste_Emprunt_Personne"];
        $listeEmprunt2 = Array();

        foreach ($listeEmprunt as $empruntBoucle )
        {
            if($empruntBoucle->getId() != $emprunt)
            {
               array_push($listeEmprunt2,$empruntBoucle);
            }
            else
            {
                array_push($listeEmpruntPersonne,$empruntBoucle);
            }
        }

        $_SESSION["liste_Emprunt"] = $listeEmprunt2;
        $_SESSION["liste_Emprunt_Personne"] = $listeEmpruntPersonne;

        // replace this example code with whatever you need
        return $this->render('participer/participer.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'listeEmprunt'=> $listeEmprunt2
        ]);
    }

}