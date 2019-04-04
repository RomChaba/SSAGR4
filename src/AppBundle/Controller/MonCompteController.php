<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Emprunt;
use AppBundle\Entity\Personne;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;

class MonCompteController extends Controller
{
    /**
     * @Route("/moncompte", name="moncompte")
     */
    public function chargementMonCompteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //TODO Aller chercher la personne en bdd avec son id dans la session
        $personne1 = new Personne();

        $personne1->setRue("rue de la poire");
        $personne1->setMail("dupont@gmail.com");
        $personne1->setMotDePasse("mdp1");
        $personne1->setNom("Dupont");
        $personne1->setPrenom("Jean");
        $personne1->setTelephone("0980473828");
        $personne1->setMotDePasse("mdp");
        $personne1->setPhoto("photo");
        $personne1->setPermis(false);
        $personne1->setActif(true);
        $personne1->setDateCreation(new DateTime());

        $this->createFormulaire($personne1); //On crée le formulaire


        $this->leFormulaire->handleRequest($request);

        // Si la requête est en POST
        if ($request->isMethod('POST')) {
            // On fait le lien Requête <-> Formulaire
           // $this->leFormulaire->handleRequest($request);
//            $validator = $this->get('validator');
//            $listeErreur = $validator->validate($personne1);

            // On vérifie que les valeurs entrées sont correctes
            if ($this->leFormulaire->isValid()) {

                if($personne1->getConfirmationMotDePasse() != null)
                {
                    $personne1->setMotDePasse($personne1->getNouveauMotDePasse());
                }

                // On enregistre notre objet $advert dans la base de données, par exemple
                //$em->persist($personne1);
                //$em->flush();

                $request->getSession()->getFlashBag()->add('compte', 'Compte bien enregistrée.');

                return $this->render('moncompte/moncompte.html.twig', array('formulairePersonne' => $this->leFormulaire->createView()));
            }
        }



        return $this->render('moncompte/moncompte.html.twig', array('formulairePersonne' => $this->leFormulaire->createView()));
    }

    private $leFormulaire = null;

    private function createFormulaire(Personne $personne)
    {

        $this->leFormulaire = $this->createFormBuilder($personne)

            ->add('nom', TextType::class, array('label' => 'Nom','required' => true))
            ->add('prenom', TextType::class, array('label' => 'Prénom','required' => true))
            ->add('mail', EmailType::class, array('label' => 'Mail'))
            ->add('rue', TextType::class, array('label' => 'Rue','required' => true))
            ->add('cp', TextType::class, array('label' => 'Code postal'))
            ->add('ville', TextType::class, array('label' => 'Ville'))
            ->add('nouveauMotDePasse', PasswordType::class, array('label' => 'Nouveau mot de passe','required' => false))
            ->add('confirmationMotDePasse', PasswordType::class, array('label' => 'Confirmation mot de passe','required' => false))
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