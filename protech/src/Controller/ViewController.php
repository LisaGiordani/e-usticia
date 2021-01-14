<?php

namespace App\Controller;

use App\Entity\Tweet;
use App\Entity\Statistics;
use App\Form\TweetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// ViewController met en relation la plupart des routes du serveur web avec leur template associée
class ViewController extends AbstractController
{

    /**
     * @Route("/result", name="view_result", methods={"GET"})
     */
    public function resultView(): Response
    {
        $tweets = $this->getDoctrine()
            ->getRepository(Tweet::class)
            ->findAll();

        $statistics = $this->getDoctrine()
                ->getRepository(Statistics::class)
                ->findAll();

        return $this->render('result/index.html.twig', [
            'tweets' => $tweets,
            'statistics' => $statistics,
        ]);
    }

    /**
     * @Route("/resultValidationNaif", name="view_result_validation_naif", methods={"GET"})
     */
    public function resultValidationNaifView(): Response
    {
        $tweets = $this->getDoctrine()
            ->getRepository(Tweet::class)
            ->findAll();

        $statistics = $this->getDoctrine()
                ->getRepository(Statistics::class)
                ->findAll();

        return $this->render('result/validation_naif.html.twig', [
            'tweets' => $tweets,
            'statistics' => $statistics,
        ]);
    }

    /**
     * @Route("/home", name="view_home", methods={"GET"})
     */
    public function homePageView(): Response
    {
        return $this->render('tab/homePage.html.twig');
    }

    /**
     * @Route("/law", name="view_law", methods={"GET"})
     */
    public function lawView(): Response
    {
        return $this->render('tab/law.html.twig');
    }

    /**
     * @Route("/contacts", name="view_contacts", methods={"GET"})
     */
    public function contactsView(): Response
    {
        return $this->render('tab/contacts.html.twig');
    }

    /**
     * @Route("/help", name="view_help", methods={"GET"})
     */
    public function helpView(): Response
    {
        return $this->render('tab/help.html.twig');
    }

    /**
     * @Route("/simpleAlgorithme", name="view_simple_algorithme", methods={"GET"})
     */
    public function simpleAlgorithmeView(): Response
    {
        return $this->render('tab/simpleAlgorithme.html.twig');
    }

    /**
     * @Route("view/IA", name="view_IA", methods={"GET"})
     */
    public function IAView(): Response
    {
        return $this->render('tab/IA.html.twig');
    }


}
