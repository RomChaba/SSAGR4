<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Vehicule;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class GestionVoitureController extends Controller
{
    /**
     * @Route("/gestionvoiture/{id}", name="gestionvoiture")
     */
    public function gestionVoitureAction(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $voituresRepo = $this->getDoctrine()->getRepository('AppBundle:Vehicule');

        if($id <= 0 || $id == null) {
            $voiture1 = new Vehicule(null,"","","");
        }
        else
        {
            $voiture1 = $voituresRepo->findOneById($id);
        }

        $this->createFormulaire($voiture1); //On crée le formulaire

        $this->leFormulaire->handleRequest($request);

        // Si la requête est en POST
        if ($request->isMethod('POST')) {
            // On fait le lien Requête <-> Formulaire

            // On vérifie que les valeurs entrées sont correctes
            if ($this->leFormulaire->isValid()) {

                if($voiture1->getId() <= 0) {
                    // Traitement spécifique pour la création
                }

                $em->persist($voiture1);
                $em->flush();

                $request->getSession()->getFlashBag()->add('voiture', 'Voiture bien enregistrée.');

                return $this->redirectToRoute("administration");
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
            ->add('Enregistrer', SubmitType::class, array('attr' => ['class' => 'btn btn-success pull-right']))
            ->getForm();
    }
}