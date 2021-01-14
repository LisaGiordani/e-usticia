<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tweet
 *
 * @ORM\Table(name="tweets")
 * @ORM\Entity
 */
class Tweet
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
     * @ORM\Column(name="author_id", type="string", length=25, nullable=false)
     */
    private $authorId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="author_name", type="string", length=50, nullable=true)
     */
    private $authorName;

    /**
     * @var string
     *
     * @ORM\Column(name="recipient_id", type="string", length=25, nullable=false)
     */
    private $recipientId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="message", type="string", length=550, nullable=true)
     */
    private $message;

    /**
     * @var string|null
     *
     * @ORM\Column(name="url", type="string", length=100, nullable=true)
     */
    private $url;


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

    public function getAuthorId(): ?string
    {
        return $this->authorId;
    }

    public function setAuthorId(string $authorId): self
    {
        $this->authorId = $authorId;

        return $this;
    }

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function setAuthorName(?string $authorName): self
    {
        $this->authorName = $authorName;

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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }


}
