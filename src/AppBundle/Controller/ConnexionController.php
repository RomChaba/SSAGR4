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

class ConnexionController extends Controller
{
    /**
     * @Route("/connexion", name="connexion")
     */
    public function ConnexionAction(Request $request)
    {

        $pers_co = $request->getSession()->get('userConnect');

        if ($pers_co != null) {
            return $this->redirectToRoute("homepage");
        }

        if (isset($_POST['login']) && !empty($_POST['username'])) {

            $perso = new Personne();
            $perso = $perso->setMail($_POST['username']);

            $repoPersonne = $this->getDoctrine()->getRepository("AppBundle:Personne");
            /** @var Personne $pers_co */
            $pers_co = $repoPersonne->findOneBy(['mail'=>$perso->getMailNoDecrypt()]);

//            dump($pers_co->_ENCRYPTE_DATA($pers_co->getMotDePasse()));
//            die();

            if($pers_co->testPassword($_POST['password'])) {
                $request->getSession()->set('userConnect', $pers_co);
                return $this->redirectToRoute('homepage');
            } else {
                return $this->render('connexion/connexion.html.twig');
            }
        }

        return $this->render('connexion/connexion.html.twig');
    }
}