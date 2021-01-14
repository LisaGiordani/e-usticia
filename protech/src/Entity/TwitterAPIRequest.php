<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class TwitterAPIRequest
{
    /**
     * @var int
     */
    private $NBTweetMax;

    /**
     * @var string
     */
    private $recipientId;

    /**
     * @var string
     */
    private $date;


    public function __construct($NBTweetMax, $recipientId, $date)
    {
      $this->setNBTweetMax($NBTweetMax);
      $this->setRecipientId($recipientId);
      $this->setDate($date);
    }


    public function getNBTweetMax(): ?int
    {
        return $this->NBTweetMax;
    }

    public function setNBTweetMax(?int $NBTweetMax): void
    {
        $this->NBTweetMax = $NBTweetMax;
    }

    public function getRecipientId(): ?string
    {
        return $this->recipientId;
    }

    public function setRecipientId(?string $recipientId): void
    {
        $this->recipientId = $recipientId;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): void
    {
        $this->date = $date;
    }

}
