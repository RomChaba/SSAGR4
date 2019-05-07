<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Personne;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;

class GestionPersonneController extends Controller
{
    /**
     * @Route("/gestionpersonne/{id}", name="gestionpersonne")
     */
    public function gestionPersonneAction(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $personnesRepo = $this->getDoctrine()->getRepository('AppBundle:Personne');

        if($id <= 0 || $id == null) {
            //TODO Aller chercher la personne en bdd avec son id dans la session
            $personne1 = new Personne();
        }
        else
        {
            $personne1 = $personnesRepo->findOneById($id);
        }

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



                if($personne1->getId() <= 0) {
                    if($personne1->getConfirmationMotDePasse() != null)
                    {
                        $personne1->setMotDePasse($personne1->getNouveauMotDePasse());
                    }

                    // On enregistre notre objet $advert dans la base de données, par exemple
                    $personne1->setDateCreation(new DateTime());
                    $personne1->setPhoto("testPhoto");
                    $personne1->setActif(true);
                }

                $em->persist($personne1);
                $em->flush();

                $request->getSession()->getFlashBag()->add('personne', 'Personne bien enregistrée.');

                return $this->redirectToRoute("administration");
            }
        }



        return $this->render('gestionpersonne/gestionpersonne.html.twig', array('formulairePersonne' => $this->leFormulaire->createView()));
    }

    private $leFormulaire = null;

    private function createFormulaire(Personne $personne)
    {

        if ($personne->getId() <= 0) {
            $this->leFormulaire = $this->createFormBuilder($personne)
                ->add('nom', TextType::class, array('label' => 'Nom', 'required' => true))
                ->add('prenom', TextType::class, array('label' => 'Prénom', 'required' => true))
                ->add('mail', EmailType::class, array('label' => 'Mail'))
                ->add('rue', TextType::class, array('label' => 'Rue', 'required' => true))
                ->add('cp', TextType::class, array('label' => 'Code postal'))
                ->add('ville', TextType::class, array('label' => 'Ville'))
                ->add('nouveauMotDePasse', PasswordType::class, array('label' => 'Mot de passe', 'required' => true))
                ->add('confirmationMotDePasse', PasswordType::class, array('label' => 'Confirmation mot de passe', 'required' => false))
                ->add('telephone', TextType::class, array('label' => 'Téléphone'))
                ->add('permis', CheckboxType::class, array('label' => 'Permis'))
                ->add('Enregistrer', SubmitType::class)
                ->getForm();
        }
        else
        {
            $this->leFormulaire = $this->createFormBuilder($personne)
                ->add('nom', TextType::class, array('label' => 'Nom', 'required' => true))
                ->add('prenom', TextType::class, array('label' => 'Prénom', 'required' => true))
                ->add('mail', EmailType::class, array('label' => 'Mail'))
                ->add('rue', TextType::class, array('label' => 'Rue', 'required' => true))
                ->add('cp', TextType::class, array('label' => 'Code postal'))
                ->add('ville', TextType::class, array('label' => 'Ville'))

                ->add('telephone', TextType::class, array('label' => 'Téléphone'))
                ->add('permis', CheckboxType::class, array('label' => 'Permis'))
                ->add('Enregistrer', SubmitType::class)
                ->getForm();
        }
    }


}