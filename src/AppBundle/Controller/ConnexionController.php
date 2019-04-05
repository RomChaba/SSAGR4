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
    public function ConnexionAction()
    {
        return $this->render('connexion/connexion.html.twig');

        if (isset($_POST['login']) && !empty($_POST['username'])
            && !empty($_POST['password'])) {

            if ($_POST['username'] == 'Dupont' &&
                $_POST['password'] == '1234') {
                $_SESSION['valid'] = true;
                $_SESSION['timeout'] = time();
                $_SESSION['username'] = 'Dupont';

                return $this->render('default/index.html.twig');
            }else {
                return $this->render('connexion/connexion.html.twig');
            }
        }
    }
}