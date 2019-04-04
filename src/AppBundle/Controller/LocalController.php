<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;



class LocalController extends Controller
{
    /**
     * Change the locale for the current user
     *
     * @param String $language
     * @return array
     *
     * @Route("/setlocale/{language}", name="setlocale")
     */
    public function setLocaleAction($language = null, Request $request)
    {
        if ($language != null) {
        // On enregistre la langue en session
            $this->get('session')->set('_locale', $language);
        }
        // Ainsi que la page actuelle
        $this->get('session')->set('_referer', $request->headers->get('referer'));

        $url = $request->getSession()->get('_referer');
        // dump($request->getSession()->get('_locale'));
        //exit();
        if (empty($url)) {
            $url = $this->container->get('router')->generate('login');
        }

        return new RedirectResponse($url);
    }
}