<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Emprunt;
use AppBundle\Entity\Lieu_emprunt;
use AppBundle\Entity\Personne;
use AppBundle\Repository\PersonneRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $repoPersonne = $this->getDoctrine()->getRepository("AppBundle:Personne");


        /** @var Personne $pers_co */
        $pers_co = $repoPersonne->findOneById(10);

        $em = $this->getDoctrine()->getManager();

        $test = new DateTime();
        //Récupération de la liste des emprunts existant
        //TODO ENLEVER ET REMPLACER
        if ($request->getSession()->get("EMPRUNT") == null) {
            $request->getSession()->set("EMPRUNT", array());
        }
        $listeEmprunt = $request->getSession()->get("EMPRUNT");


        $new_liste = array();


        /** @var Emprunt $emprunt */
        foreach ($listeEmprunt as $emprunt) {

            if ($emprunt->getListePersonne()[0]->getId() != $pers_co->getId()) {
                array_push($new_liste,$emprunt);
            }
        }


        $lieu_emprunt = $request->getSession()->get("LIEU_EMPRUNT");

        $listeLieu = $em->getRepository('AppBundle:Lieu')->findAll();

        // replace this example code with whatever you need
        return $this->render('participer/participer.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'listeEmprunt'=> $new_liste,
            'lieu_emprunt'=> $lieu_emprunt,
            'listeLieu'=> $listeLieu,
            'pers_co'=> $pers_co,
        ]);
    }

    /**
     * @Route("/detail-emprunt/{idemprunt}", name="detailEmprunt")
     */
    public function detailVoyageAction(Request $request, $idemprunt)
    {

//      ****** Recuperation de l'emprunt dans la liste ******
        $listeEmprunt = $request->getSession()->get("EMPRUNT");
        /** @var Emprunt $unEmprunt */
        foreach ($listeEmprunt as $unEmprunt){
            if ($unEmprunt->getId() == $idemprunt){
                /** @var Emprunt $emprunt */
                $emprunt = $unEmprunt;
                break;
            }
        }

//      ****** Recuperation de l'utilisateur connecté ******
        $repoPersonne = $this->getDoctrine()->getRepository("AppBundle:Personne");

        /** @var Personne $pers_co */
        $pers_co = $repoPersonne->findOneById(10);


//        ****** Recuêration du lien entre les lieux et les emprunts ******
        $lieu_emprunt = $request->getSession()->get("LIEU_EMPRUNT");
        $new_liste = array();

        /** @var Lieu_emprunt $lieu_emp */
        foreach ($lieu_emprunt as $lieu_emp){
            if ($lieu_emp->getEmpruntId() == $emprunt->getId()) {
                if ($lieu_emp->getDepart() == true) {
                    $new_liste[0]=$lieu_emp;
                } else {
                    $new_liste[1]=$lieu_emp;
                }
            }
        }

        dump($emprunt);
        dump($new_liste);

        return $this->render(
            'participer/detail.html.twig',
            array(
                "messageEnregistrement"=>"OKKKKKKK",
                "pers_co"=>$pers_co,
                "emprunt"=>$emprunt,
                "lieu_emprunt"=>$new_liste,
            )
        );


    }


    /**
     * @Route("/retard", name="retard")
     */
    public function retardAction(Request $request)
    {

//        idEmprunt
//        retard_date_prevu
//        retard_retard
//        retard_cause


        //      ****** Recuperation de l'utilisateur connecté ******
        $repoEmprunt = $this->getDoctrine()->getRepository("AppBundle:Emprunt");

        /** @var Personne $pers_co */
        $emprunt = $repoEmprunt->findOneById($request->get("idEmprunt"));



        $retour = array(
            "message"=>"RAS",
            "ok"=>true,
            "param"=>$request->request->all(),
        );


        return JsonResponse::create($retour);
    }





    /**
     * @Route("/participer-passager/{empruntId}/{personneId}", name="participer_passager")
     */
    public function clickParticiperAction(Request $request,$empruntId,$personneId)
    {
        $repoEmprunt = $this->getDoctrine()->getRepository("AppBundle:Emprunt");
        /** @var Emprunt $emprunt */
//        $emprunt = $repoEmprunt->findOneById($empruntId);
        $liste_emprunt = $request->getSession()->get("EMPRUNT");

        foreach ($liste_emprunt as $k => $unemp){
            if ($unemp->getId() == $empruntId) {
                $emplacement = $k;
                $emprunt = $unemp;
            }
        }

//        ***** RECUPERATION PERSONNE *****

        $repoPersonne = $this->getDoctrine()->getRepository("AppBundle:Personne");
        /** @var Personne $pers_co */
        $pers_co = $repoPersonne->findOneById($personneId);

        $emprunt->getListePersonne()->add($pers_co);

        $liste_emprunt[$emplacement] = $emprunt;

        $request->getSession()->set("EMPRUNT",$liste_emprunt);

        return $this->redirectToRoute("detailEmprunt",["idemprunt"=>$empruntId]);
    }



    /**
     * @Route("/plus-participer-passager/{empruntId}/{personneId}", name="plus_participer_passager")
     */
    public function plusParticiperAction(Request $request,$empruntId,$personneId)
    {
        $repoEmprunt = $this->getDoctrine()->getRepository("AppBundle:Emprunt");
        /** @var Emprunt $emprunt */
//        $emprunt = $repoEmprunt->findOneById($empruntId);
        $liste_emprunt = $request->getSession()->get("EMPRUNT");

        foreach ($liste_emprunt as $k => $unemp){
            if ($unemp->getId() == $empruntId) {
                $emplacement = $k;
                $emprunt = $unemp;
            }
        }

//        ***** RECUPERATION PERSONNE *****

        $repoPersonne = $this->getDoctrine()->getRepository("AppBundle:Personne");
        /** @var Personne $pers_co */
        $pers_co = $repoPersonne->findOneById($personneId);

        $new_liste = new ArrayCollection();

        foreach ($emprunt->getListePersonne() as $k => $unePers) {
            if ($unePers->getId() != $pers_co->getId()) {
                $new_liste[$k] = $unePers;
            }
        }
        $emprunt->setListePersonne($new_liste);

        $liste_emprunt[$emplacement] = $emprunt;

        $request->getSession()->set("EMPRUNT",$liste_emprunt);

        return $this->redirectToRoute("detailEmprunt",["idemprunt"=>$empruntId]);


    }

}