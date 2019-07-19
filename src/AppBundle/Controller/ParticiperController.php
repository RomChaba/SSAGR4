<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Emprunt;
use AppBundle\Entity\Emprunt_Personne;
use AppBundle\Entity\Lieu_emprunt;
use AppBundle\Entity\Personne;
use AppBundle\Repository\PersonneRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
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
        $pers_co = $request->getSession()->get('userConnect');

        if ($pers_co == null) {
            return $this->redirectToRoute("connexion");
        }

        $em = $this->getDoctrine()->getManager();

        $test = new DateTime();
        //Récupération de la liste des emprunts existant

        $listeEmprunt = $em->getRepository("AppBundle:Emprunt")->findAll();


        $new_liste = array();


        /** @var Emprunt $emprunt */
        foreach ($listeEmprunt as $emprunt) {

            /** @var Emprunt_Personne $emp_pers */
            foreach ($emprunt->getListePersonne() as $emp_pers) {
                if ($emp_pers->getPersonneId()->getId() != $pers_co->getId()){
                    array_push($new_liste,$emprunt);

                }
            }
        }
        $lieu_emprunt = null;

        $listeLieu = $em->getRepository('AppBundle:Lieu')->findAll();
//        dump($new_liste);
//die();
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

//        date_default_timezone_set('Europe/Paris');
        $dateDuJour = getdate();


        $em = $this->getDoctrine()->getManager();
        $emprunt = $em->getRepository("AppBundle:Emprunt")->findOneBy(["id"=>$idemprunt]);



//      ****** Recuperation de l'utilisateur connecté ******
        $repoPersonne = $this->getDoctrine()->getRepository("AppBundle:Personne");

        /** @var Personne $pers_co */
        $pers_co = $request->getSession()->get('userConnect');


//        ****** Recupêration du lien entre les lieux et les emprunts ******
        $lieu_emprunt = array();
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

//        dump($emprunt);
//        dump($new_liste);

        return $this->render(
            'participer/detail.html.twig',
            array(
                "messageEnregistrement"=>"OKKKKKKK",
                "pers_co"=>$pers_co,
                "emprunt"=>$emprunt,
                "lieu_emprunt"=>$new_liste,
                "dateDuJour"=>$dateDuJour,
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
        /** @var Emprunt $emprunt */
        $em = $this->getDoctrine()->getManager();
        $emprunt = $em->getRepository("AppBundle:Emprunt")->findOneBy(["id"=>$empruntId]);


//        ***** RECUPERATION PERSONNE *****

        /** @var Personne $pers_co */
        $pers_co = $em->getRepository("AppBundle:Personne")->findOneById($personneId);



        $empruntPersonne = new Emprunt_Personne();

        $empruntPersonne->setPersonneId($pers_co);
        $empruntPersonne->setEmpruntId($emprunt);
        $empruntPersonne->setConducteur(false);

        $emprunt->getListePersonne()->add($empruntPersonne);

        $em->persist($emprunt);
        $em->flush();

        return $this->redirectToRoute("detailEmprunt",["idemprunt"=>$empruntId]);
    }

    /**
     * @Route("/plus-participer-passager/{empruntId}/{personneId}", name="plus_participer_passager")
     */
    public function plusParticiperAction(Request $request,$empruntId,$personneId)
    {
        /** @var Emprunt $emprunt */
        $em = $this->getDoctrine()->getManager();
        $emprunt = $em->getRepository("AppBundle:Emprunt")->findOneBy(["id"=>$empruntId]);

//        ***** RECUPERATION PERSONNE *****
        /** @var Personne $pers_co */
        $pers_co = $em->getRepository("AppBundle:Personne")->findOneById($personneId);


        /** @var Emprunt_Personne $item */
        foreach ($emprunt->getListePersonne() as $item) {
            if ($pers_co->getId() == $item->getPersonneId()->getId()){
                $em->remove($item);
            }
        }
        $em->flush();

        $em->refresh($emprunt);

        return $this->redirectToRoute("detailEmprunt",["idemprunt"=>$empruntId]);


    }

    /**
     * @Route("/rendre-cle/{empruntId}",name="rendre_cle")
     */
    public function rendreCle(Request $request, $empruntId)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Emprunt $emprunt */
        $emprunt = $em->getRepository("AppBundle:Emprunt")->findOneBy(["id"=>$empruntId]);


        // Variables concernant l'email
        $repoParametre = $this->getDoctrine()->getRepository("AppBundle:Parametre");
        $destinataire = $repoParametre->findOneBy(['cle'=>'mail_contact']);
        $destinataire = $destinataire->getValeur(); // Adresse email de l'administrateur


        $sujet = 'Titre du message'; // Titre de l'email
        $contenu = '<html><head><title>Clé</title></head><body>';
        $contenu .= '<p>Bonjour, le voyage N°'.$emprunt->getId().' rend les clés.</p>';
        $contenu .= '<p><strong>Arrivé</strong>: ' . $request->request->get("heureArrive") . '</p>';
        $contenu .= '<p><strong>Message</strong>: ' . $request->request->get("messageArrive") . '</p>';
        $contenu .= '</body></html>'; // Contenu du message de l'email

        // Pour envoyer un email HTML, l'en-tête Content-type doit être défini
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // TODO tester une fois le site en ligne
         mail($destinataire, $sujet, $contenu, $headers); // Fonction principale qui envoi l'email

        return $this->redirectToRoute("detailEmprunt",["idemprunt"=>$empruntId]);

    }
}