<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Emprunt;
use AppBundle\Entity\Lieu;
use AppBundle\Entity\Lieu_emprunt;
use AppBundle\Entity\Personne;
use AppBundle\Form\LieuType;
use AppBundle\Repository\PersonneRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncode;

//use Symfony\Component\Validator\Constraints\DateTime;
class LieuController extends Controller
{
    /**
     * @Route("/ajax/nouveaulieu", name="new_lieu_ajax")
     */
    public function newLieuAction(Request $request)
    {
        $lieu = new Lieu();


        $form_lieu = $this->createForm(LieuType::class,$lieu);
        $form_lieu->handleRequest($request);

        if ($form_lieu->isSubmitted() && $form_lieu->isValid()) {

            /** @var Lieu $lieu */
            $lieu = $form_lieu->getData();

            $lieu->setLatitude(47.218372);
            $lieu->setLongitude(-1.553621);
            $lieu->setSiteOfficiel(false);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lieu);
            $entityManager->flush();


            return JsonResponse::create($lieu->__toString());
        }
        return JsonResponse::create();
    }
}