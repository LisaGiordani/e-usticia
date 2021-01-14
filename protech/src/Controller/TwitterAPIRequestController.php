<?php

namespace App\Controller;

use App\Entity\TwitterAPIConnection;
use App\Entity\TwitterAPIRequest;
use App\Entity\TwitterAPIExchange;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TwitterAPIRequestController extends AbstractController
{

    public function get8Requests(int $NBTweetMax, string $recipientId): array
    {

      $dates = $this->get8Dates();

      $requests = array();
      for($k=0; $k<=7; $k++){
        $twitterAPIrequest = new TwitterAPIRequest($NBTweetMax, $recipientId, $dates[$k]);
        array_push($requests, $twitterAPIrequest);
      }

    return $requests;
  }

  // get8Dates() rend un tableau de 8 dates qui correspondent aux 8 derniers jours
  // à compter de la date actuelle
  public function get8Dates(): array
  {

    $today = date('Y-m-d');
    $dates = array();

    for($k=0; $k<=7; $k++){
      $j= strval($k);
      $date = date('Y-m-d', strtotime($today." -".$j." day"));
      array_push($dates,$date);
    }
    return $dates;
    }

}
