<?php

namespace App\Controller;

use App\Entity\Insult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InsultController extends AbstractController
{

    // getInsults() récupére les insultes stockées dans la table insults
    // et les rend sous forme de tableau de string
    public function getInsults($entityManager): array
    {
      $DB_insults = $entityManager->getRepository(Insult::class)->findAll();
      $array_insults = $this->intoStringArray($DB_insults);
      return $array_insults;
    }

    // intoArray() transforme un tableau d'objet de la classe Insult
    // en un tableau de string correspant aux terms des insultes
    public function intoStringArray($DB_insults): array
    {
      $nb_insults = count($DB_insults);
      $array_insults = array();
      for ($k=0; $k<$nb_insults ; $k++)
      {
        $terms = $DB_insults[$k]->getTerms();
        array_push($array_insults,$terms);
      }
      return $array_insults;
    }
}
