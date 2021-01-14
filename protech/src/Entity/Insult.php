<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Insult
 *
 * @ORM\Table(name="insults")
 * @ORM\Entity
 */
class Insult
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="terms", type="text", length=65535, nullable=false)
     */
    private $terms;

    public function getTerms(): ?string
    {
        return $this->terms;
    }

}
