<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Personne;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
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
            $personne1 = new Personne();
        }
        else
        {
            $personne1 = $personnesRepo->findOneById($id);
            //$personne1->setNouveauMotDePasse($personne1->getMotDePasse());
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
                    // On enregistre notre objet $advert dans la base de données, par exemple
                    $personne1->setDateCreation(new DateTime());
                    $personne1->setPhoto("testPhoto");
                    $personne1->setActif(true);
                }

                if($personne1->getConfirmationMotDePasse() != null)
                {
                    $personne1->setMotDePasse($personne1->getNouveauMotDePasse());
                }
                $personne1->setCp($personne1->getCp(),true);
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
        if($personne->getId() <= 0) {

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
                ->add('permis', CheckboxType::class, array('label' => 'Permis', 'required' => false))
                ->add('isAdmin', CheckboxType::class, array('label' => 'Administrateur', 'required' => false))
                ->add('Enregistrer', SubmitType::class, array('attr' => ['class' => 'btn btn-success pull-right']))
                ->getForm();
        }
        else {

            $this->leFormulaire = $this->createFormBuilder($personne)
                ->add('nom', TextType::class, array('label' => 'Nom', 'required' => true))
                ->add('prenom', TextType::class, array('label' => 'Prénom', 'required' => true))
                ->add('mail', EmailType::class, array('label' => 'Mail'))
                ->add('rue', TextType::class, array('label' => 'Rue', 'required' => true))
                ->add('cp', TextType::class, array('label' => 'Code postal'))
                ->add('ville', TextType::class, array('label' => 'Ville'))
                ->add('nouveauMotDePasse', PasswordType::class, array('label' => 'Mot de passe', 'required' => false))
                ->add('confirmationMotDePasse', PasswordType::class, array('label' => 'Confirmation mot de passe', 'required' => false))
                ->add('telephone', TextType::class, array('label' => 'Téléphone'))
                ->add('permis', CheckboxType::class, array('label' => 'Permis', 'required' => false))
                ->add('isAdmin', CheckboxType::class, array('label' => 'Administrateur', 'required' => false))
                ->add('Enregistrer', SubmitType::class, array('attr' => ['class' => 'btn btn-success pull-right']))
                ->getForm();
        }
    }

    /**
     * @Route("/importcsv", name="importcsv")
     */
    public function importCSV(){
        if (isset($_POST["import"])) {

            $fileName = $_FILES["file"]["tmp_name"];

            if ($_FILES["file"]["size"] > 0) {

                $file = fopen($fileName, "r");
                $em = $this->getDoctrine()->getManager();
                while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                    $personne = new Personne();
                    $personne->setNom($column[0]);
                    $personne->setPrenom($column[1]);
                    $personne->setMail($column[2]);
                    $personne->setMotDePasse($column[3]);
                    $em->persist($personne);
                    $sqlInsert = "INSERT into personne (nom,prenom,mail,motDePasse)
                   values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "')";

                    if (! empty($result)) {
                        $type = "success";
                        $message = "CSV Data Imported into the Database";
                    } else {
                        $type = "error";
                        $message = "Problem in Importing CSV Data";
                    }
                }
                $em->flush();
                $this->redirectToRoute("administration", ["type"=>$type,"message"=>$message]);
            }
        }
    }


}