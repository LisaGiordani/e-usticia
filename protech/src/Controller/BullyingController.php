<?php

namespace App\Controller;

use App\Entity\Tweet;
use App\Entity\Statistics;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// BullyingController détecte et rend les tweets considérés
// comme pouvant témoigner de harcèlement parmi un tableau de tweets donné ;
// et calcule les statistiques brutes associées à ces tweets
class BullyingController extends AbstractController
{

    public function getBullying(array $tweets, string $recipientId, array $insults, array $scores, $entityManager, Statistics $stats): void
    {
      $countBullyingTweets = 0;
      $vp = 0;
      $fp = 0;
      $vn = 0;
      $fn = 0;
      $recall = -1;
      $precision = -1;
      $nb_tweets = count($tweets);

      for ($k=0; $k<$nb_tweets ; $k++)
      {
          if ($recipientId != "démo" && $recipientId != "validation_naif"){
            $message = $tweets[$k]['text'];
          }
          if ($recipientId == "démo" || $recipientId == "validation_naif"){
            $message = $tweets[$k];
          }
          $insult_in = $this->insultIn($message, $insults);

          if ($insult_in == true) {

            if ($recipientId != "démo" && $recipientId != "validation_naif"){
              $tweet = new Tweet();
              $tweet->setDate($tweets[$k]['created_at']);
              $tweet->setAuthorId($tweets[$k]['user']['screen_name']);
              $tweet->setAuthorName($tweets[$k]['user']['name']);
              $tweet->setRecipientId($recipientId);
              $tweet->setMessage($message);
              $tweet->setUrl("https://twitter.com/i/web/status/".$tweets[$k]['id']);

              $entityManager->persist($tweet);
              $entityManager->flush();
            }

            if ($recipientId == "démo"){
              $tweet = new Tweet();
              $tweet->setDate(date('Y-m-d H:i:s'));
              $tweet->setAuthorId("démo");
              $tweet->setAuthorName("démo");
              $tweet->setRecipientId("démo");
              $tweet->setMessage(substr($message, 0, 300));
              $tweet->setUrl(null);

              $entityManager->persist($tweet);
              $entityManager->flush();
            }

            if ($recipientId == "validation_naif"){
              if ($scores[$k] == 1) {
                $vp = $vp + 1;
              }
              if ($scores[$k] == 0) {
                $fp = $fp + 1;
              }
            }

            $countBullyingTweets = $countBullyingTweets + 1;
        }

        if ($insult_in == false){
          if ($recipientId == "validation_naif"){
            if ($scores[$k] == 1) {
              $fn = $fn + 1;
            }
            if ($scores[$k] == 0) {
              $vn = $vn + 1;
            }
          }
        }

      }
      $stats->setCountTweets($nb_tweets);
      $stats->setCountBullying($countBullyingTweets);

      if ($recipientId == "validation_naif"){
        $stats->setVp($vp);
        $stats->setFp($fp);
        $stats->setVn($vn);
        $stats->setFn($fn);
    }

}


    public function insultIn(string $message, array $insults): bool
    {
      $message = strtolower($message);
      $words = explode(" ",$message);
      $nb_words = count($words);
      $bool = false;
      for ($i = 0; $i<$nb_words; $i++)
      {
        if (in_array($words[$i], $insults) == 1) {
          $bool = true;
        }
      }
      return $bool;
    }
}
