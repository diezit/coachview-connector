<?php

namespace Diezit\CoachviewConnector\Classes;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class Opleiding extends CoachviewData
{
    /** @var string */
    protected $id;
    protected $naam;
    protected $code;
    protected $publicatie;
    protected $publicatiePlanning;
    protected $opmerking;
    protected $startLocatie;
    protected $contactPersoon;
    protected $startDatum;
    protected $eindDatum;
    protected $aantalPlaatsenBezet;
    protected $opleidingssoort;
    protected $aantalPlaatsenMax;
    protected $studiePunten;

    public function all(int $offset = null, int $limit = null): Collection
    {
        $params = $this->makeParams(['skip' => $offset, 'take' => $limit]);
        $data = $this->coachview->getData('/api/v1/Opleidingen', $params);

        $response = [];
        foreach ($data as $coachViewCourse) {
            $response[] = $this->getCourseFromCoachViewData($coachViewCourse);
        }

        return collect($response);
    }

    public function hydrate(object $coachViewCourse): Opleiding
    {
        $this
            ->setId($coachViewCourse->id)
            ->setNaam($coachViewCourse->naam)
            ->setCode($coachViewCourse->code)
            ->setPublicatie($coachViewCourse->publicatie)
            ->setPublicatiePlanning($coachViewCourse->publicatiePlanning)
            ->setOpmerking($coachViewCourse->opmerking)
            ->setStartDatum($coachViewCourse->startDatum)
            ->setEindDatum($coachViewCourse->eindDatum)
            ->setAantalPlaatsenBezet($coachViewCourse->aantalPlaatsenBezet)
            ->setAantalPlaatsenMax($coachViewCourse->aantalPlaatsenMax);

        if ($coachViewCourse->startLocatie) {
            $this->setStartLocatie($coachViewCourse->startLocatie->lokaal);
        }

        if ($coachViewCourse->opleidingssoortId) {
            $template = (new Opleidingssoort($this->coachview))->hydrate($coachViewCourse->opleidingssoort);
            $this->setOpleidingssoort($template);
        }

        return $this;
    }

    protected function getCourseFromCoachViewData($coachViewCourse): Opleiding
    {
        return (new Opleiding($this->coachview))->hydrate($coachViewCourse);
    }

    /**
     * @return Collection|CourseComponent[]
     */
    public function components(): Collection
    {
        return $this->coachview->courseComponent()->getForCourse($this->id);
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNaam()
    {
        return $this->naam;
    }

    public function setNaam($naam): self
    {
        $this->naam = $naam;
        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getPublicatie(): ?bool
    {
        return $this->publicatie;
    }

    public function setPublicatie(?bool $publicatie): self
    {
        $this->publicatie = $publicatie;
        return $this;
    }

    public function getPublicatiePlanning(): ?bool
    {
        return $this->publicatiePlanning;
    }

    public function setPublicatiePlanning(?bool $publicatiePlanning): self
    {
        $this->publicatiePlanning = $publicatiePlanning;
        return $this;
    }

    public function getOpmerking()
    {
        return $this->opmerking;
    }

    public function setOpmerking($opmerking): self
    {
        $this->opmerking = $opmerking;
        return $this;
    }

    public function getStartLocatie()
    {
        return $this->startLocatie;
    }

    public function setStartLocatie($startLocatie): self
    {
        $this->startLocatie = $startLocatie;
        return $this;
    }

    public function getContactPersoon(): Persoon
    {
        return $this->contactPersoon;
    }

    public function setContactPersoon(Persoon $contactPersoon): self
    {
        $this->contactPersoon = $contactPersoon;
        return $this;
    }

    public function getStartDatum(): Carbon
    {
        return $this->startDatum;
    }

    public function setStartDatum($startDatum): self
    {
        $this->startDatum = new Carbon($startDatum);
        return $this;
    }

    public function getEindDatum(): Carbon
    {
        return $this->eindDatum;
    }

    public function setEindDatum($eindDatum): self
    {
        $this->eindDatum = new Carbon($eindDatum);
        return $this;
    }

    public function getAantalPlaatsenBezet()
    {
        return $this->aantalPlaatsenBezet;
    }

    public function setAantalPlaatsenBezet($aantalPlaatsenBezet): self
    {
        $this->aantalPlaatsenBezet = $aantalPlaatsenBezet;
        return $this;
    }

    public function getAantalPlaatsenMax()
    {
        return $this->aantalPlaatsenMax;
    }

    public function setAantalPlaatsenMax($aantalPlaatsenMax): self
    {
        $this->aantalPlaatsenMax = $aantalPlaatsenMax;
        return $this;
    }

    public function getOpleidingssoort(): ?Opleidingssoort
    {
        return $this->opleidingssoort;
    }

    private function setOpleidingssoort(Opleidingssoort $opleidingssoort): self
    {
        $this->opleidingssoort = $opleidingssoort;
        return $this;
    }

    public function getStudiePunten(): ?int
    {
        return $this->studiePunten;
    }

    public function setStudiePunten(?int $studiePunten): self
    {
        $this->studiePunten = $studiePunten;
        return $this;
    }

    public function getByCode(string $code): ?Opleiding
    {
        $params = $this->makeParams(['where' => 'code='.$code]);
        $data = $this->coachview->getData('/api/v1/Opleidingen', $params);
        $coachViewCourse = current($data);
        return $this->hydrate($coachViewCourse);
    }
}
