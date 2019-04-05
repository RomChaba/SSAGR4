<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Vehicule;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;

class GestionVoitureController extends Controller
{
    /**
     * @Route("/gestionvoiture", name="gestionvoiture")
     */
    public function gestionVoitureAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //TODO Aller chercher la personne en bdd avec son id dans la session
        $voiture1 = new Vehicule();

//        $personne1->setRue("rue de la poire");
//        $personne1->setMail("dupont@gmail.com");
//        $personne1->setMotDePasse("mdp1");
//        $personne1->setNom("Dupont");
//        $personne1->setPrenom("Jean");
//        $personne1->setTelephone("0980473828");
//        $personne1->setMotDePasse("mdp");
//        $personne1->setPhoto("photo");
//        $personne1->setPermis(false);
//        $personne1->setActif(true);
//        $personne1->setDateCreation(new DateTime());

        $this->createFormulaire($voiture1); //On crée le formulaire


        $this->leFormulaire->handleRequest($request);

        // Si la requête est en POST
        if ($request->isMethod('POST')) {
            // On fait le lien Requête <-> Formulaire

            // On vérifie que les valeurs entrées sont correctes
            if ($this->leFormulaire->isValid()) {

                if($voiture1->getId() <= 0) {
                    // On enregistre notre objet $advert dans la base de données, par exemple
//                    $personne1->setDateCreation(new DateTime());
//                    $personne1->setPhoto("testPhoto");
//                    $personne1->setActif(true);

                    $em->persist($voiture1);
                    $em->flush();
                }

                $request->getSession()->getFlashBag()->add('voiture', 'Voiture bien enregistrée.');

                return $this->render('Administration/administration.html.twig');
            }
        }



        return $this->render('gestionvoiture/gestionvoiture.html.twig', array('formulaireVoiture' => $this->leFormulaire->createView()));
    }

    private $leFormulaire = null;

    private function createFormulaire(Vehicule $voiture)
    {

        $this->leFormulaire = $this->createFormBuilder($voiture)

            ->add('libelle', TextType::class, array('label' => 'Libellé','required' => true))
            ->add('couleur', TextType::class, array('label' => 'Couleur','required' => true))
            ->add('immatriculation', TextType::class, array('label' => 'Immatriculation'))
            ->add('Enregistrer', SubmitType::class)
            ->getForm();

    }
}