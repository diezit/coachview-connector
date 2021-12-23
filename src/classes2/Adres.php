<?php

namespace Diezit\CoachviewConnector\Classes;

use Diezit\CoachviewConnector\Interfaces\AdresInterface;

class Adres extends CoachviewData implements AdresInterface
{
    protected $adres1;
    protected $adres2;
    protected $adres3;
    protected $adres4;
    protected $postcode;
    protected $plaats;
    protected $landCode;

    public static function fromCoachViewData($coachview, $coachViewAdres): Adres
    {
        return (new Adres($coachview))
            ->setAdres1($coachViewAdres->adres1)
            ->setAdres2($coachViewAdres->adres2)
            ->setAdres3($coachViewAdres->adres3)
            ->setAdres4($coachViewAdres->adres4)
            ->setPostcode($coachViewAdres->postcode)
            ->setPlaats($coachViewAdres->plaats)
            ->setLandCode($coachViewAdres->landCode);
    }

    public function getAdres1(): ?string
    {
        return $this->adres1;
    }

    public function setAdres1(?string $adres1): self
    {
        $this->adres1 = $adres1;
        return $this;
    }

    public function getAdres2(): ?string
    {
        return $this->adres2;
    }

    public function setAdres2(?string $adres2): self
    {
        $this->adres2 = $adres2;
        return $this;
    }

    public function getAdres3(): ?string
    {
        return $this->adres3;
    }

    public function setAdres3(?string $adres3): self
    {
        $this->adres3 = $adres3;
        return $this;
    }

    public function getAdres4(): ?string
    {
        return $this->adres4;
    }

    public function setAdres4(?string $adres4): self
    {
        $this->adres4 = $adres4;
        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): self
    {
        $this->postcode = $postcode;
        return $this;
    }

    public function getPlaats(): ?string
    {
        return $this->plaats;
    }

    public function setPlaats(?string $plaats): self
    {
        $this->plaats = $plaats;
        return $this;
    }

    public function getLandCode(): ?string
    {
        return $this->landCode;
    }

    public function setLandCode(?string $landCode): self
    {
        $this->landCode = $landCode;
        return $this;
    }
}
