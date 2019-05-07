<?php
/**
 * Created by PhpStorm.
 * User: gvecoven
 * Date: 04/04/2019
 * Time: 15:09
 */

namespace AppBundle\Controller;


use AppBundle\Entity\MailContact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;

class MailContactController extends Controller
{
    /**
     * @Route("/mailcontact", name="mailcontact")
     */
    public function mailContactAction(Request $request)
    {
        $mailContact = new MailContact();
        $mailContact->setMailContact("mailContact@test.fr");

        $this->createFormulaire($mailContact); //On crée le formulaire


        $this->leFormulaire->handleRequest($request);

        // Si la requête est en POST
        if ($request->isMethod('POST')) {

            // On vérifie que les valeurs entrées sont correctes
            if ($this->leFormulaire->isValid()) {

                $request->getSession()->getFlashBag()->add('mailContact', 'Mail du contact bien enregistrée.');
                dump($request->getSession()->getFlashBag());
                //die();

                return $this->redirectToRoute("administration");
            }
        }



        return $this->render('mailcontact/mailcontact.html.twig', array('formulaireMailcontact' => $this->leFormulaire->createView()));
    }

    private $leFormulaire = null;


    private function createFormulaire(MailContact $mailContact)
    {
        $this->leFormulaire = $this->createFormBuilder($mailContact)

            ->add('mailContact', TextType::class)
            ->add('Enregistrer', SubmitType::class)
            ->getForm();
    }


}