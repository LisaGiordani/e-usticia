<?php

namespace App\Controller;

use App\Entity\WebRequest;
use App\Form\WebRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web/request")
 */
class WebRequestController extends AbstractController
{

    // new() crée une nouvelle instance de WebRequest à partir des informations saisies
    // dans le formulaire et la stocke dans la table web_requests
    /**
     * @Route("/new", name="web_request_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $webRequest = new WebRequest();
        $form = $this->createForm(WebRequestType::class, $webRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($webRequest);
            $entityManager->flush();

            return $this->redirectToRoute('view_simple_algorithme');
        }

        return $this->render('web_request/new.html.twig', [
            'web_request' => $webRequest,
            'form' => $form->createView(),
        ]);
    }

    // getLastRecipientId() récupère le dernier identifiant Twitter de la victime présumée,
    // saisi par un utilisateur via l’interface utilisateur, dans la table web_requests
    public function getLastRecipientId($entityManager): string
    {
      $DB_web_request = $entityManager->getRepository(WebRequest::class)->findAll();
      $nb_web_requests = count($DB_web_request);
      $array_recipientId = array();
      for ($k=0; $k<$nb_web_requests ; $k++)
      {
        $recipientId = $DB_web_request[$k]->getRecipientId();
        array_push($array_recipientId,$recipientId);
      }
      $recipientId = $array_recipientId[$nb_web_requests-1];
      return $recipientId;
    }

}
