<?php


namespace AppBundle\Controller;

//ob_start();
//session_start();
use AppBundle\Entity\Emprunt;
use AppBundle\Entity\Personne;
use AppBundle\Entity\Site;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Vehicule;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DeconnexionController extends Controller
{
    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function DeconnexionAction(Request $request)
    {
        $request->getSession()->set('userConnect', null);
        return $this->redirectToRoute('homepage');
    }
}