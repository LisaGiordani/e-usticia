<?php

namespace App\Controller;

use App\Entity\TweetDemo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TweetDemoController extends AbstractController
{
    // getAllTweetsDemo() récupère tous les tweets présents dans la table tweets_demo
    // et les rend sous forme d'un tableau de messages (string)
    public function getAllTweetsDemo($entityManager): array
    {
      $DB_demo = $entityManager->getRepository(TweetDemo::class)->findAll();
      $array_all_tweets_demo = $this->tweetsIntoArray($DB_demo);
      return $array_all_tweets_demo;
    }

    // getAllScores() récupère tous les scores présents dans la table tweets_demo
    // et les rend sous forme d'un tableau de scores (integer)
    public function getAllScores($entityManager): array
    {
      $DB_demo = $entityManager->getRepository(TweetDemo::class)->findAll();
      $array_all_scores = $this->scoresIntoArray($DB_demo);
      return $array_all_scores;
    }

    // tweetsIntoArray() transforme un tableau d’instance de la classe TweetDemo
    // en un tableau de messages (string)
    public function tweetsIntoArray($DB_demo): array
    {
      $nb_tweets_demo = count($DB_demo);
      $array_tweets_demo = array();
      for ($k=0; $k<$nb_tweets_demo ; $k++)
      {
        $message = $DB_demo[$k]->getMessage();
        array_push($array_tweets_demo,$message);
      }
      return $array_tweets_demo;
    }

    // tweetsIntoArray() transforme un tableau d’instance de la classe TweetDemo
    // en un tableau de scores (integer)
    public function scoresIntoArray($DB_demo): array
    {
      $nb_scores = count($DB_demo);
      $array_scores = array();
      for ($k=0; $k<$nb_scores; $k++)
      {
        $score = $DB_demo[$k]->getScore();
        array_push($array_scores,$score);
      }
      return $array_scores;
    }

    // getTweetsDemo() rend le tableau des messages associés à des indices donnés
    public function getTweetsDemo(array $array_all_tweets_demo, array $index_tweets_demo): array
    {
      $nb_tweets_demo = count($index_tweets_demo);
      $array_tweets_demo = array();
      for ($k=0; $k<$nb_tweets_demo; $k++)
      {
          array_push($array_tweets_demo,$array_all_tweets_demo[$index_tweets_demo[$k]]);
      }
      return $array_tweets_demo;
    }

    // getScores() rend le tableau des scores associés à des indices donnés
    public function getScores(array $array_all_scores, array $index_tweets_demo): array
    {
      $nb_scores = count($index_tweets_demo);
      $array_scores = array();
      for ($k=0; $k<$nb_scores; $k++)
      {
          array_push($array_scores,$array_all_scores[$index_tweets_demo[$k]]);
      }
      return $array_scores;
    }


}
