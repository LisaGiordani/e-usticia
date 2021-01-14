<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WebRequest
 *
 * @ORM\Table(name="web_requests")
 * @ORM\Entity
 */
class WebRequest
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
     * @ORM\Column(name="date", type="string", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="recipientId", type="string", length=25, nullable=false)
     */
    private $recipientId;

    function __construct()
    {
      $this->setDate(date('Y-m-d'));
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRecipientId(): ?string
    {
        return $this->recipientId;
    }

    public function setRecipientId(string $recipientId): self
    {
        $this->recipientId = $recipientId;

        return $this;
    }

}
