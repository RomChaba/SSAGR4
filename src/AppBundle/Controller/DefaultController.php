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
