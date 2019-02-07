<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Personne;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

////        $tmp = new Personne();
////        $tmp->setNom("toto");
////        $tmp->setPrenom("toto");
////        $tmp->setMail("toto");
////        $tmp->setMotDePasse("toto");
////        $tmp->setPhoto("toto");
////        $tmp->setTelephone("0213252415");
////        $tmp->setAdresse("0213252415");
////        $tmp->setBoolPermis(true);
////
////        $em->persist($tmp);
////        $em->flush();
//        $comptes = $em->getRepository('AppBundle:Personne')->findOneById(3);
//
//        dump($comptes);

        $em = $this->getDoctrine()->getManager();

        $listeEmprunt = $em->getRepository('AppBundle:Personne')->findAll();
        dump($listeEmprunt);

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'listeEmprunt'=> $listeEmprunt
        ]);
    }
}
