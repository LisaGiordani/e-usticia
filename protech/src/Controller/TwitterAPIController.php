<?php

namespace App\Controller;

use App\Entity\TwitterAPIConnection;
use App\Entity\TwitterAPIRequest;
use App\Entity\TwitterAPIExchange;
use App\Controller\TweetController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class TwitterAPIController extends AbstractController
{
    // getResult() envoie une requête à l'API Twitter
    // et rend les résultats obtenus sous forme de tableau
    public function getResult(TwitterAPIConnection $twitterAPIconnection, TwitterAPIRequest $twitterAPIrequest): array
    {

      $NBTweetMax = $twitterAPIrequest->getNBTweetMax();
      $NBmax = strval($NBTweetMax);
      $recipientId = $twitterAPIrequest->getRecipientId();
      $date = $twitterAPIrequest->getDate();
      $settings = $twitterAPIconnection->getSettings();
      $url = $twitterAPIconnection->getUrl();

      $getfield= "?q=%20to:".$recipientId."&count=".$NBmax."&until=".$date;
      $requestMethod = "GET";

      $twitterAPI = new TwitterAPIExchange($settings);

      $result = json_decode($twitterAPI->setGetfield($getfield)
              ->buildOauth($url, $requestMethod)
              ->performRequest(),$assoc = TRUE);

      $array = $result["statuses"];

      return $array;
    }

    // get8Results() envoie 8 requêtes à l'API Twitter données
    // et rend les résultats obtenus sous forme d'un unique tableau
    public function get8Results(TwitterAPIConnection $twitterAPIconnection, array $twitterAPI8Requests): array
    {
      $tweetController = new TweetController();

      $results = array();
      for ($k=0; $k<=7; $k++) {
        $result1day = $this->getResult($twitterAPIconnection, $twitterAPI8Requests[$k]);
        $results = $tweetController->addTweets($result1day, $results);
      }

      return $results;
    }

}
