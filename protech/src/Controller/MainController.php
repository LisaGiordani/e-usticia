<?php

namespace App\Controller;

use App\Entity\TwitterAPIConnection;
use App\Entity\Statistics;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// MainController met en relation tous les acteurs avec les algorithmes de détection du cyber-harcèlement.
// On peut y retrouver les 3 modes de fonctionnement des algorithmes : normal, démo et validation.
/**
 * @Route("/main")
 */
class MainController extends AbstractController
{
    /**
   * @Route("/generateNaif", name="main_generateNaif", methods={"GET"})
   */
    public function generateNaif()
    {
      $entityManager = $this->getDoctrine()->getManager();

      ////////////////////////// Suppression des tweets de la table tweets
      $tweetController = new TweetController();
      $tweetController->deleteAll($entityManager);

      ////////////////////////// Suppression des statistiques de la table statistics
      $statisticsController = new StatisticsController();
      $statisticsController->deleteAll($entityManager);

      ////////////////////////// Récupération de l'id de la victime présumée
      $webRequestController = new WebRequestController();
      $recipientId = $webRequestController->getLastRecipientId($entityManager);

      ////////////////////////// Connection à l'API Twitter
      $settings = array(
          'oauth_access_token' => "1308765160467828736-rJvp6amtRT8pRtxZ5kKPk1TM9ZIBXN",
          'oauth_access_token_secret' => "ELdg6TVrMd6FKX2TJK9XslV7jLp9Y33JKYn0eRQ84DuPc",
          'consumer_key' => "sadLxTJ4NjuGK8xnEbpcMFx2w",
          'consumer_secret' => "ijqDVtK6RWV6TNNRE2LVescq4XNjki5lM3MRVf8WTbDDCZldc7"
      );
      $url= "https://api.twitter.com/1.1/search/tweets.json";
      $twitterAPIconnection = new TwitterAPIConnection($settings, $url);

      ////////////////////////// Création des 8 requêtes vers l'API Twitter correspondant aux tweets reçus au cours des 8 derniers jours
      $NBTweetMax = 100;

      $twitterAPIrequestController = new TwitterAPIRequestController();
      $requests = $twitterAPIrequestController->get8Requests($NBTweetMax, $recipientId);

      ////////////////////////// Création de l'instance de Statistics associée à cette recherche
      $stats = new Statistics($recipientId, date('Y-m-d'));

      ////////////////////////// Obtention des résultats des 8 requêtes vers l'API Twitter pour les 8 derniers jours
      $twitterAPIcontroller = new TwitterAPIController();
      $tweets = $twitterAPIcontroller->get8Results($twitterAPIconnection, $requests);

      ////////////////////////// Collecte les insultes de la table insults
      $insultController = new InsultController();
      $insults = $insultController->getInsults($entityManager);

      ////////////////////////// Détection et stockage des tweets possèdant au moins une insulte
      $bullyingController = new BullyingController();
      $bullyingController->getBullying($tweets, $recipientId, $insults, array(), $entityManager, $stats);

      ////////////////////////// Mise à jour des statistiques et stockage dans la table statistics
      $statisticsController = new StatisticsController();
      $statisticsController->update($stats, $entityManager);

      return $this->redirectToRoute('view_result');
    }



    /**
   * @Route("/generateIA", name="main_generateIA", methods={"GET"})
   */
    public function generateIA()
    {
      $entityManager = $this->getDoctrine()->getManager();

      ////////////////////////// Suppression des tweets de la table tweets
      $tweetController = new TweetController();
      $tweetController->deleteAll($entityManager);

      ////////////////////////// Suppression des statistiques de la table statistics
      $statisticsController = new StatisticsController();
      $statisticsController->deleteAll($entityManager);

      ////////////////////////// Récupération de l'id de la victime présumée
      $webRequestController = new WebRequestController();
      $recipientId = $webRequestController->getLastRecipientId($entityManager);

      ////////////////////////// Connection à l'API Twitter
      $settings = array(
          'oauth_access_token' => "1308765160467828736-rJvp6amtRT8pRtxZ5kKPk1TM9ZIBXN",
          'oauth_access_token_secret' => "ELdg6TVrMd6FKX2TJK9XslV7jLp9Y33JKYn0eRQ84DuPc",
          'consumer_key' => "sadLxTJ4NjuGK8xnEbpcMFx2w",
          'consumer_secret' => "ijqDVtK6RWV6TNNRE2LVescq4XNjki5lM3MRVf8WTbDDCZldc7"
      );
      $url= "https://api.twitter.com/1.1/search/tweets.json";
      $twitterAPIconnection = new TwitterAPIConnection($settings, $url);

      ////////////////////////// Création des 8 requêtes vers l'API Twitter correspondant aux tweets reçus au cours des 8 derniers jours
      $NBTweetMax = 100;
      $twitterAPIrequestController = new TwitterAPIRequestController();
      $requests = $twitterAPIrequestController->get8Requests($NBTweetMax, $recipientId);

      ////////////////////////// Création de l'instance de Statistics associée à cette recherche
      $stats = new Statistics($recipientId, date('Y-m-d'));

      ////////////////////////// Obtention des résultats des 8 requêtes vers l'API Twitter pour les 8 derniers jours
      $twitterAPIcontroller = new TwitterAPIController();
      $tweets = $twitterAPIcontroller->get8Results($twitterAPIconnection, $requests);

      ////////////////////////// Utilisation du code Python (IA) pour détecter les tweets insultants
      ////////////////////////// Stockage des tweets insultants

      ////////////////////////// Mise à jour des statistiques et stockage dans la table statistics
      $statisticsController = new StatisticsController();
      $statisticsController->update($stats, $entityManager);

      //return $this->redirectToRoute('view_result');
      return $this->render('tab/error.html.twig');
    }




    /**
    * @Route("/generateDemoNaif", name="main_generateDemoNaif", methods={"GET"})
    */
    public function generateDemoNaif()
    {
      $entityManager = $this->getDoctrine()->getManager();
      $recipientId = "démo";

      ////////////////////////// Suppression des tweets de la table tweets
      $tweetController = new TweetController();
      $tweetController->deleteAll($entityManager);

      ////////////////////////// Suppression des statistiques de la table statistics
      $statisticsController = new StatisticsController();
      $statisticsController->deleteAll($entityManager);

      ////////////////////////// Création de l'instance de Statistics associée à cette recherche
      $stats = new Statistics($recipientId, date('Y-m-d'));

      ////////////////////////// Obtention des tweets à analyser pour la démo
      $NBTweetMax = 100;
      $tweetDemoController = new TweetDemoController();
      $all_tweets = $tweetDemoController->getAllTweetsDemo($entityManager);
      $index_tweets = array_rand($all_tweets, $NBTweetMax);
      $tweets = $tweetDemoController->getTweetsDemo($all_tweets, $index_tweets);

      ////////////////////////// Collecte les insultes de la table insults
      $insultController = new InsultController();
      $insults = $insultController->getInsults($entityManager);

      ////////////////////////// Détection et stockage des tweets possèdant au moins une insulte
      $bullyingController = new BullyingController();
      $bullyingController->getBullying($tweets, $recipientId, $insults, array(), $entityManager, $stats);

      ////////////////////////// Mise à jour des statistiques et stockage dans la table statistics
      $statisticsController = new StatisticsController();
      $statisticsController->update($stats, $entityManager);

      return $this->redirectToRoute('view_result');
    }




    /**
    * @Route("/generateDemoIA", name="main_generateDemoIA", methods={"GET"})
    */
    public function generateDemoIA()
    {
      $entityManager = $this->getDoctrine()->getManager();
      $recipientId = "démo";

      ////////////////////////// Suppression des tweets de la table tweets
      $tweetController = new TweetController();
      $tweetController->deleteAll($entityManager);

      ////////////////////////// Suppression des statistiques de la table statistics
      $statisticsController = new StatisticsController();
      $statisticsController->deleteAll($entityManager);

      ////////////////////////// Création de l'instance de Statistics associée à cette recherche
      $stats = new Statistics($recipientId, date('Y-m-d'));

      ////////////////////////// Obtention des tweets à analyser pour la démo
      $NBTweetMax = 100;
      $tweetDemoController = new TweetDemoController();
      $all_tweets = $tweetDemoController->getAllTweetsDemo($entityManager);
      $index_tweets = array_rand($all_tweets, $NBTweetMax);
      $tweets = $tweetDemoController->getTweetsDemo($all_tweets, $index_tweets);

      ////////////////////////// Utilisation du code Python (IA) pour détecter les tweets insultants
      ////////////////////////// Stockage des tweets insultants

      ////////////////////////// Mise à jour des statistiques et stockage dans la table statistics
      $statisticsController = new StatisticsController();
      $statisticsController->update($stats, $entityManager);

      //return $this->redirectToRoute('view_result');
      return $this->render('tab/error.html.twig');
    }





    /**
    * @Route("/validateNaif", name="validate_naif", methods={"GET"})
    */
    public function validateNaif()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $recipientId = "validation_naif";
        $NBTweetMax = 10000;
        $NBValidation = 5;
        $tweetDemoController = new TweetDemoController();

        ////////////////////////// Suppression des tweets de la table tweets
        $tweetController = new TweetController();
        $tweetController->deleteAll($entityManager);

        ////////////////////////// Suppression des statistiques de la table statistics
        $statisticsController = new StatisticsController();
        $statisticsController->deleteAll($entityManager);

        ////////////////////////// Récupération de tous les tweets annotés et leurs scores à partir de la table tweets_demo
        $all_tweets = $tweetDemoController->getAllTweetsDemo($entityManager);
        $all_scores = $tweetDemoController->getAllScores($entityManager);

        ////////////////////////// Collecte des insultes de la table insults
        $insultController = new InsultController();
        $insults = $insultController->getInsults($entityManager);

        for ($k=0; $k<$NBValidation; $k++) {
            ////////////////////////// Création de tableaux de tweets et de leurs scores de taille $NBTweetMax
            $index_tweets = array_rand($all_tweets, $NBTweetMax);
            $tweets = $tweetDemoController->getTweetsDemo($all_tweets, $index_tweets);
            $scores = $tweetDemoController->getScores($all_scores, $index_tweets);

            ////////////////////////// Création de l'instance de Statistics associée à cette recherche
            $stats = new Statistics($recipientId, date('Y-m-d'));

            ////////////////////////// Détection et stockage des tweets possèdant au moins une insulte
            $bullyingController = new BullyingController();
            $bullyingController->getBullying($tweets, $recipientId, $insults, $scores, $entityManager, $stats);

            ////////////////////////// Mise à jour des statistiques et stockage dans la table statistics
            $statisticsController->update($stats, $entityManager);
        }
        ////////////////////////// Calcul de la moyenne des statistiques et stockage de cet objet dans la table statistics
        $statisticsController->average($entityManager);

        return $this->redirectToRoute('view_result_validation_naif');
    }


}
