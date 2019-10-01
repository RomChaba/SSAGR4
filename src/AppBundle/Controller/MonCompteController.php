<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Emprunt;
use AppBundle\Entity\Emprunt_Personne;
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

        /** @var Personne $pers_co */
        $pers_co = $request->getSession()->get('userConnect');

        //On crée le formulaire
        $this->createFormulaire($pers_co);

        $listeEmpruntPersonne = $em->getRepository("AppBundle:Emprunt_Personne")->findBy(['personneId'=>$pers_co->getId()]);
//        dump($listeEmpruntPersonne);

        $listeEmprunt = null;
        /** @var Emprunt_Personne $item  */
        foreach ($listeEmpruntPersonne as $item) {
            $listeEmprunt[] = $item->getEmpruntId();
        }


        $this->leFormulaire->handleRequest($request);
        // Si la requête est en POST
        if ($request->isMethod('POST')) {
            // On fait le lien Requête <-> Formulaire
           // $this->leFormulaire->handleRequest($request);
//            $validator = $this->get('validator');
//            $listeErreur = $validator->validate($personne1);

            // On vérifie que les valeurs entrées sont correctes
            if ($this->leFormulaire->isValid()) {

                if($pers_co->getConfirmationMotDePasse() != null)
                {
                    $pers_co->setMotDePasse($pers_co->getNouveauMotDePasse());
                }

                // On enregistre notre objet $advert dans la base de données, par exemple
                //$em->persist($personne1);
                //$em->flush();

                $request->getSession()->getFlashBag()->add('compte', 'Compte bien enregistré.');
                $request->getSession()->set('userConnect', $pers_co);

                // Récupréation de la liste de ses voyages



                return $this->render(
                    'moncompte/moncompte.html.twig',
                    array(
                        'formulairePersonne' => $this->leFormulaire->createView(),
                        'listeEmprunt' => $listeEmprunt,
                    )
                );
            }
        }




//        dump($listeEmprunt);



        return $this->render(
            'moncompte/moncompte.html.twig',
            array(
                'formulairePersonne' => $this->leFormulaire->createView(),
                'listeEmprunt' => $listeEmprunt,

            )
        );
    }


    private $leFormulaire = null;
    private function createFormulaire(Personne $personne)
    {
        $this->leFormulaire = $this->createFormBuilder($personne)

            ->add('nom', TextType::class, array('label' => 'Nom','required' => true))
            ->add('prenom', TextType::class, array('label' => 'Prénom','required' => true))
            ->add('mail', EmailType::class, array('label' => 'Mail','attr' => array(
                'readonly' => true,
            )))
            ->add('rue', TextType::class, array('label' => 'Rue','required' => true))
            ->add('cp', TextType::class, array('label' => 'Code postal'))
            ->add('ville', TextType::class, array('label' => 'Ville'))
            ->add('nouveauMotDePasse', PasswordType::class, array('label' => 'Nouveau mot de passe','required' => false))
            ->add('confirmationMotDePasse', PasswordType::class, array('label' => 'Confirmation mot de passe','required' => false))
            ->add('Enregistrer', SubmitType::class, array('attr' => ['class' => 'btn btn-success pull-right']))
            ->getForm();

    }
}