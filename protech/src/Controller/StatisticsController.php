<?php

namespace App\Controller;

use App\Entity\Statistics;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatisticsController extends AbstractController
{

    // deleteAll() vide la table statistics
    public function deleteAll($entityManager): void
    {
        $DB_stats = $entityManager->getRepository(Statistics::class)->findAll();
        $len_stats = count($DB_stats);
        if ($len_stats != 0)
        {
          for ($k=0; $k<$len_stats ; $k++)
          {
            $entityManager->remove($DB_stats[$k]);
            $entityManager->flush();
          }
        }
    }

    // update() calcule l’ensemble des attributs d’un objet de la classe Statistics
    // à partir des statistiques brutes qui lui sont déjà attribuées,
    // puis stocke cet objet dans la table statistics
    public function update(Statistics $stats, $entityManager): void
    {
      $nb_tweets = $stats->getCountTweets();
      $vp = $stats->getVp();
      $fp = $stats->getFp();
      $vn = $stats->getVn();
      $fn = $stats->getFn();

      if ($nb_tweets != 0){
        $stats->setPourcentage($stats->getCountBullying()/$nb_tweets*100);
      }
      else {
          $stats->setPourcentage(-1);
      }

      if (($vp + $fn) != 0) {
        $stats->setFnRate($fn/($vp+$fn));
        $recall = $vp/($vp+$fn);
        $stats->setRecall($recall);
      }
      else {
        $stats->setFnRate(-1);
        $recall = -1;
        $stats->setRecall($recall);
      }

      if (($vp + $fp) != 0) {
        $stats->setFpRate($fp/($vp+$fp));
        $precision = $vp/($vp+$fp);
        $stats->setPrecision($precision);
      }
      else {
        $stats->setFpRate(-1);
        $precision = -1;
        $stats->setPrecision($precision);
      }

      if (($precision+$recall) != 0 && $recall != -1 && $precision != -1){
        $stats->setFScore(2*$precision*$recall/($precision+$recall));
      }
      else {
        $stats->setFScore(-1);
      }

      $entityManager->persist($stats);
      $entityManager->flush();
    }

    // average() calcule la moyenne des attributs des objets de la Statitics déjà générés,
    // puis stocke cet objet dans la table statistics
    public function average($entityManager): void
    {
      $avg_stats = new Statistics("moyenne_validation", date('Y-m-d'));
      $avg_countBullying = 0;
      $avg_vp = 0;
      $avg_fp = 0;
      $avg_vn = 0;
      $avg_fn = 0;

      $DB_stats = $entityManager->getRepository(Statistics::class)->findAll();
      $len_stats = count($DB_stats);

      for ($k=0; $k<$len_stats ; $k++)
      {
          $avg_countBullying = $avg_countBullying + $DB_stats[$k]->getCountBullying();
          $avg_vp = $avg_vp + $DB_stats[$k]->getVp();
          $avg_fp = $avg_fp + $DB_stats[$k]->getFp();
          $avg_vn = $avg_vn + $DB_stats[$k]->getVn();
          $avg_fn = $avg_fn + $DB_stats[$k]->getFn();
      }

      $avg_stats->setCountTweets($DB_stats[0]->getCountTweets());
      $avg_stats->setCountBullying($avg_countBullying/$len_stats);
      $avg_stats->setVp($avg_vp/$len_stats);
      $avg_stats->setFp($avg_fp/$len_stats);
      $avg_stats->setVn($avg_vn/$len_stats);
      $avg_stats->setFn($avg_fn/$len_stats);

      $this->update($avg_stats, $entityManager);

      $entityManager->persist($avg_stats);
      $entityManager->flush();
    }

}
