<?php

namespace App\Controller;

use App\Entity\Tweet;
use App\Entity\Statistics;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/tweet")
 */
class TweetController extends AbstractController
{

    // show() affiche un tweet donné
    /**
     * @Route("/{id}", name="tweet_show", methods={"GET"})
     */
    public function show(Tweet $tweet): Response
    {
        return $this->render('result/show_tweet.html.twig', [
            'tweet' => $tweet,
        ]);
    }

    // delete() supprime un tweet donné de la table tweets
    /**
     * @Route("/{id}", name="tweet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tweet $tweet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tweet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tweet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('view_result');
    }

    // deleteAll() supprime tous les tweets stockés dans la table tweets
    public function deleteAll($entityManager): void
    {
        $DB_tweet = $entityManager->getRepository(Tweet::class)->findAll();
        $len_tweet = count($DB_tweet);
        if ($len_tweet != 0)
        {
          for ($k=0; $k<$len_tweet ; $k++)
          {
            $entityManager->remove($DB_tweet[$k]);
            $entityManager->flush();
          }
        }
    }

    // addTweets() ajoute des tweets dans un tableau de tweets donné sans doublons
    public function addTweets(array $tweets2add, array $tweets): array
    {
      $nb_tweets2add = count($tweets2add);
      for ($k=0; $k<$nb_tweets2add; $k++) {
        $isRegistered = $this->isRegisteredTweet($tweets2add[$k], $tweets);
        if ($isRegistered == false) {
          array_push($tweets, $tweets2add[$k]);
        }
      }

      return $tweets;
    }

    // isRegisteredTweet() vérifie qu’un tweet appartient ou non à un tableau de tweets donné
    public function isRegisteredTweet(array $tweet2check, array $tweets): bool
    {
      return in_array($tweet2check, $tweets);
    }

}
