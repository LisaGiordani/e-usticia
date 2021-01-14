<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Statistics
 *
 * @ORM\Table(name="statistics")
 * @ORM\Entity
 */
class Statistics
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
     * @ORM\Column(name="recipientId", type="text", length=65535, nullable=false)
     */
    public $recipientId;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", nullable=false)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="count_tweets", type="integer", nullable=false)
     */
    private $countTweets;

    /**
     * @var int
     *
     * @ORM\Column(name="count_bullying", type="integer", nullable=false)
     */
    private $countBullying;

    /**
     * @var float
     *
     * @ORM\Column(name="pourcentage", type="float", nullable=false)
     */
    private $pourcentage;

    /**
     * @var int
     *
     * @ORM\Column(name="vp", type="integer", nullable=false)
     */
    private $vp;

    /**
     * @var int
     *
     * @ORM\Column(name="fp", type="integer", nullable=false)
     */
    private $fp;

    /**
     * @var int
     *
     * @ORM\Column(name="vn", type="integer", nullable=false)
     */
    private $vn;

    /**
     * @var int
     *
     * @ORM\Column(name="fn", type="integer", nullable=false)
     */
    private $fn;

    /**
     * @var float
     *
     * @ORM\Column(name="fpRate", type="float", nullable=false)
     */
    private $fpRate;

    /**
     * @var float
     *
     * @ORM\Column(name="fnRate", type="float", nullable=false)
     */
    private $fnRate;

    /**
     * @var float
     *
     * @ORM\Column(name="recall", type="float", nullable=false)
     */
    private $recall;

    /**
     * @var float
     *
     * @ORM\Column(name="vpp", type="float", nullable=false)
     */
    private $precision;

    /**
     * @var float
     *
     * @ORM\Column(name="fScore", type="float", nullable=false)
     */
    private $fScore;


    function __construct($recipientId, $date)
    {
      $this->setRecipientId($recipientId);
      $this->setDate($date);
      $this->setCountTweets(0);
      $this->setCountBullying(0);
      $this->setPourcentage(0);
      $this->setVp(0);
      $this->setFp(0);
      $this->setVn(0);
      $this->setFn(0);
      $this->setFpRate(0);
      $this->setFnRate(0);
      $this->setRecall(0);
      $this->setPrecision(0);
      $this->setFScore(0);
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

    public function getCountTweets(): ?int
    {
        return $this->countTweets;
    }

    public function setCountTweets(?int $countTweets): void
    {
        $this->countTweets = $countTweets;
    }

    public function getCountBullying(): ?int
    {
        return $this->countBullying;
    }

    public function setCountBullying(?int $countBullying): void
    {
        $this->countBullying = $countBullying;
    }

    public function getPourcentage(): ?float
    {
        return $this->pourcentage;
    }

    public function setPourcentage(?float $pourcentage): void
    {
        $this->pourcentage = $pourcentage;
    }

    public function getVp(): ?int
    {
        return $this->vp;
    }

    public function setVp(?int $vp): void
    {
        $this->vp = $vp;
    }

    public function getFp(): ?int
    {
        return $this->fp;
    }

    public function setFp(?int $fp): void
    {
        $this->fp = $fp;
    }

    public function getVn(): ?int
    {
        return $this->vn;
    }

    public function setVn(?int $vn): void
    {
        $this->vn = $vn;
    }

    public function getFn(): ?int
    {
        return $this->fn;
    }

    public function setFn(?int $fn): void
    {
        $this->fn = $fn;
    }

    public function getFpRate(): ?float
    {
        return $this->fpRate;
    }

    public function setFpRate(?float $fpRate): void
    {
        $this->fpRate = $fpRate;
    }

    public function getFnRate(): ?float
    {
        return $this->fnRate;
    }

    public function setFnRate(?float $fnRate): void
    {
        $this->fnRate = $fnRate;
    }

    public function getRecall(): ?float
    {
        return $this->recall;
    }

    public function setRecall(?float $recall): void
    {
        $this->recall = $recall;
    }

    public function getPrecision(): ?float
    {
        return $this->precision;
    }

    public function setPrecision(?float $precision): void
    {
        $this->precision = $precision;
    }

    public function getFScore(): ?float
    {
        return $this->fScore;
    }

    public function setFScore(?float $fScore): void
    {
        $this->fScore = $fScore;
    }


}
