<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 06/02/2019
 * Time: 16:41
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     */
    public function indexAction()
    {
        return $this->render('Contact/contact.html.twig');
    }

    /**
     * @Route("/sendMail", name="contact")
     */
    public function sendMailAction(Request $request)
    {
        // S'il y des données de postées
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Code PHP pour traiter l'envoi de l'email

            $nombreErreur = 0; // Variable qui compte le nombre d'erreur
            $erreur = "Oups, il y a eu des erreurs. Veuillez examiner vos informations."; // Variable du(des) message(s) d'erreur(s)
            $tableauErreur = array();

            // Définit toutes les erreurs possibles
            if (!isset($_POST['email'])) { // Si la variable "email" du formulaire n'existe pas (il y a un problème)
                $nombreErreur++; // On incrémente la variable qui compte les erreurs
                $erreur1 = 'Quelque chose ne va pas avec la variable "email".';
                array_push($tableauErreur, $erreur1);
            } else { // Sinon, cela signifie que la variable existe (c'est normal)
                if (empty($_POST['email'])) { // Si la variable est vide
                    $nombreErreur++; // On incrémente la variable qui compte les erreurs
                    $erreur2 = 'Oubli de mail...';
                    array_push($tableauErreur, $erreur2);
                } else {
                    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                        $nombreErreur++; // On incrémente la variable qui compte les erreurs
                        $erreur3 = 'Cet email ne ressemble pas un email.';
                        array_push($tableauErreur, $erreur3);
                    }
                }
            }

            if (!isset($_POST['message'])) {
                $nombreErreur++;
                $erreur4 = '<p>Quelque chose ne va pas avec la variable "message".</p>';
            } else {
                if (empty($_POST['message'])) {
                    $nombreErreur++;
                    $erreur5 = 'Vous avez oublié de donner un message.';
                    array_push($tableauErreur, $erreur5);
                }
            }

            /** TEST */
            if (!isset($_POST['g-recaptcha-response'])) {
                $nombreErreur++;
                $erreur6 = 'Quelque chose ne va pas avec la variable "captcha".';
                array_push($tableauErreur, $erreur6);
            } else {
                $params = [
                    'secret'    => '6Lc2sbkUAAAAAM1GQxEZnIwXHP2bg6L9W535vnNm',
                    'response'  => $_POST['g-recaptcha-response']
                ];

                $url = "https://www.google.com/recaptcha/api/siteverify?" . http_build_query($params);
                if (function_exists('curl_version')) {
                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_HEADER, false);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_TIMEOUT, 1);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Evite les problèmes, si le ser
                    $response = curl_exec($curl);
                } else {
                    // Si curl n'est pas dispo, un bon vieux file_get_contents
                    $response = file_get_contents($url);
                }

                if (empty($response) || is_null($response)) {
                    $nombreErreur++;
                    $erreur6 = 'Il y a un problème avec la variable "captcha".';
                    array_push($tableauErreur, $erreur6);
                }

                $json = json_decode($response);
                if($json->success == false) {
                    $nombreErreur++; // On incrémente la variable qui compte les erreurs
                    $erreur7 = 'Captcha non résolu';
                    array_push($tableauErreur, $erreur7);
                }

            }


            /** FIN TEST */

            if ($nombreErreur == 0) { // S'il n'y a pas d'erreur
                // Récupération des variables et sécurisation des données
                $nom = htmlentities($_POST['nom']); // htmlentities() convertit des caractères "spéciaux" en équivalent HTML
                $email = htmlentities($_POST['email']);
                $message = htmlentities($_POST['message']);

                // Variables concernant l'email
                $repoParametre = $this->getDoctrine()->getRepository("AppBundle:Parametre");
                $destinataire = $repoParametre->findOneBy(['cle'=>'mail_contact']);
                $destinataire = $destinataire->getValeur(); // Adresse email de l'administrateur

                $sujet = 'Titre du message'; // Titre de l'email
                $contenu = '<html><head><title>Titre du message</title></head><body>';
                $contenu .= '<p>Bonjour, vous avez reçu un message à partir de votre site web.</p>';
                $contenu .= '<p><strong>Nom</strong>: ' . $nom . '</p>';
                $contenu .= '<p><strong>Email</strong>: ' . $email . '</p>';
                $contenu .= '<p><strong>Message</strong>: ' . $message . '</p>';
                $contenu .= '</body></html>'; // Contenu du message de l'email

                // Pour envoyer un email HTML, l'en-tête Content-type doit être défini
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                // TODO tester une fois le site en ligne
                mail($destinataire, $sujet, $contenu, $headers); // Fonction principale qui envoi l'email

                return $this->render('Contact/contact.html.twig', array('messageOk' => 'message_envoye')); //On envoie à la vue... une vue générée par le constructeur de formulaire.
            } else {
                return $this->render('Contact/contact.html.twig', array('erreurs' => $erreur, 'tableauErreur' => $tableauErreur)); //On envoie à la vue... une vue générée par le constructeur de formulaire.
            }
        } else {
            return $this->render('Contact/contact.html.twig'); // Dans le cas d'un changement de langue après l'envoi de mail
        }
    }
}


