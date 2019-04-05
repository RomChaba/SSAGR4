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

 //       $request->getSession()->set("EMPRUNT",array());
//        $request->getSession()->set("LIEU_EMPRUNT",array());
//        #region Variable de test
//        $personne1 = new Personne();
//        $personne1->setId(1);
//        $personne1->setRue("rue de la poire");
//        $personne1->setMail("dupont@gmail.com");
//        $personne1->setMotDePasse("mdp1");
//        $personne1->setNom("dupont");
//        $personne1->setPrenom("jean");
//        $personne1->setTelephone("0980473828");
//        $personne1->setPermis(true);
//        $personne1->setPhoto("photoTemp");
//
//        $v1 = new Vehicule();
//        $v1->setId(1);
//        $v1->setImmatriculation("ss-522-sd");
//        $v1->setDisponibilite(true);
//        $v1->setCouleur("Rouge");
//        $v1->setLibelle("Voiture 1");
//
//        $v2 = $v1;
//        $v2->setId(2);
//        $v2->setLibelle("Voiture 2");
//
//        $emp1 = new Emprunt();
//        $emp1->setId(1);
//        $emp1->setVehiculeId($v1);
//        $emp1->setCommentaire("Commentaire 1");
//
//        $emp2 = new Emprunt();
//        $emp2->setId(2);
//        $emp2->setVehiculeId($v2);
//        $emp2->setCommentaire("Commentaire 2");

        #endregion







        $em = $this->getDoctrine()->getManager();

        $test = new DateTime();
        dump($test);

//        $listeEmprunt = array();
//        if (!isset($_SESSION["liste_Emprunt"])) {
//
//            $listeEmprunt= [
//                $emp1,
//                $emp2
//            ];
//
//            $_SESSION["liste_Emprunt"] = $listeEmprunt;
//        }else{
//            $listeEmprunt = $_SESSION["liste_Emprunt"];
//
////            array_push($listeEmprunt,$this->get("new_emprunt"));
//        }
     /*   $tampon = $this->getDoctrine()->getmanager();

        $em = $this->getDoctrine()->getRepository('AppBundle:Personne');
        $personne1 = $em->findOneBy(array('id'=>'12'));
        $personne1->setPrenom('Jean');
        $tampon->persist($personne1);
        $tampon->flush();
        die();*/
        $listeEmprunt = $request->getSession()->get("EMPRUNT");
        $lieu_emprunt = $request->getSession()->get("LIEU_EMPRUNT");
        dump($listeEmprunt);
        dump($lieu_emprunt);
//        die();

//        $listeEmprunt = $em->getRepository('AppBundle:Personne')->findAll();
//        dump($listeEmprunt);

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'listeEmprunt'=> $listeEmprunt,
            'lieu_emprunt'=> $lieu_emprunt,
        ]);
    }

}
