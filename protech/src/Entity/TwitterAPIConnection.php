<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class TwitterAPIConnection
{
    /**
     * @var array
     */
    private $settings;

    /**
     * @var string
     */
    private $url;

    function __construct($settings, $url)
    {
      $this->setSettings($settings);
      $this->setUrl($url);
    }


    public function getSettings(): ?array
    {
        return $this->settings;
    }

    public function setSettings(?array $settings): void
    {
        $this->settings = $settings;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }


}
