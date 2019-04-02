<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Emprunt;
use AppBundle\Entity\Personne;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Validator\Constraints\DateTime;
class MonCompteController extends Controller
{
    /**
     * @Route("/moncompte", name="moncompte")
     */
    public function chargementMonCompteAction(Request $request)
    {
        //$em = $this->getDoctrine()->getManager();

        $personne1 = new Personne();

        $personne1->setRue("rue de la poire");
        $personne1->setMail("dupont@gmail.com");
        $personne1->setMotDePasse("mdp1");
        $personne1->setNom("Dupont");
        $personne1->setPrenom("Jean");
        $personne1->setTelephone("0980473828");
       // $personne1->setBoolPermis(true);
        //$personne1->setPhoto("photoTemp");

        $this->createFormulaire($personne1); //On crée le formulaire

//      Partie gestion du formulaire
        $this->leFormulaire->handleRequest($request);

        // replace this example code with whatever you need
        return $this->render('moncompte/moncompte.html.twig', array('formulairePersonne' => $this->leFormulaire->createView()));
    }

    private $leFormulaire = null;

    private function createFormulaire(Personne $personne)
    {

        $this->leFormulaire = $this->createFormBuilder($personne)

            ->add('nom', TextType::class, array('label' => 'Nom','required' => true))
            ->add('prenom', TextType::class, array('label' => 'Prénom','required' => true))
            ->add('mail', TextType::class, array('label' => 'Mail','required' => true))
            ->add('rue', TextType::class, array('label' => 'Adresse','required' => true))
            ->add('cp', TextType::class, array('label' => 'Code postal'))
            ->add('ville', TextType::class, array('label' => 'Ville'))
            ->add('motDePasse', TextType::class, array('label' => 'Nouveaux Mot de passe'))
            ->add('motDePasse', TextType::class, array('label' => 'Confirmation mot de passe'))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();

    }

//    /**
//     * @Route("/participer2", name="clickparticiper")
//     */
//    public function clickParticiperAction(Request $request, $emprunt)
//    {
//        $listeEmprunt = $_SESSION["liste_Emprunt"];
//        $listeEmpruntPersonne = $_SESSION["liste_Emprunt_Personne"];
//        $listeEmprunt2 = Array();
//
//        foreach ($listeEmprunt as $empruntBoucle )
//        {
//            if($empruntBoucle->getgetNbJourLocation() != $emprunt)
//            {
//                array_push($listeEmprunt2,$empruntBoucle);
//            }
//            else
//            {
//                array_push($listeEmpruntPersonne,$empruntBoucle);
//            }
//        }
//
//        $_SESSION["liste_Emprunt"] = $listeEmprunt2;
//        $_SESSION["liste_Emprunt_Personne"] = $listeEmpruntPersonne;
//
//        // replace this example code with whatever you need
//        return $this->render('participer/participer.html.twig', [
//            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
//            'listeEmprunt'=> $listeEmprunt2
//        ]);
//    }

}