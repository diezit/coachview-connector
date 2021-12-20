<?php

namespace Diezit\CoachviewConnector\Classes;

use Carbon\Carbon;
use Diezit\CoachviewConnector\Coachview;
use Illuminate\Support\Collection;

class Opleiding extends CoachviewData
{
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

    public function all($offset = null, $limit = null): Collection
    {
        $params = $this->makeParams(['skip' => $offset, 'take' => $limit]);
        $data = $this->coachview->getData('/api/v1/Opleidingen', $params);


        $response = [];
        foreach ($data as $coachViewCourse) {
            $response[] = $this->getCourseFromCoachViewData($coachViewCourse);
        }

        return collect($response);
    }

    private function getCourseFromCoachViewData($coachViewCourse): Opleiding
    {
        $course = (new Opleiding($this->coachview))
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
            $course->setStartLocatie($coachViewCourse->startLocatie->lokaal);
        }

        if ($coachViewCourse->opleidingssoortId) {
            $template = (new CourseTemplate($this->coachview))
                ->getCourseTemplateFromCoachViewData($coachViewCourse->opleidingssoort);
            $course->setTemplate($template);
        }

        return $course;
    }

    /**
     * @return Collection|CourseComponent
     */
    public function components(): Collection
    {
        return $this->coachview->courseComponent()->getForCourse($this->id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
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

    public function getPublicatie()
    {
        return $this->publicatie;
    }

    public function setPublicatie($publicatie): self
    {
        $this->publicatie = $publicatie;
        return $this;
    }

    public function getPublicatiePlanning()
    {
        return $this->publicatiePlanning;
    }

    public function setPublicatiePlanning($publicatiePlanning): self
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

    public function getContactPersoon(): Person
    {
        return $this->contactPersoon;
    }

    public function setContactPersoon(Person $contactPersoon): self
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
        return $this->places;
    }

    public function setAantalPlaatsenMax($attendees): self
    {
        $this->aantalPlaatsenMax = $attendees;
        return $this;
    }

    public function getOpleidingssoort(): ?CourseTemplate
    {
        return $this->opleidingssoort;
    }

    private function setOpleidingssoort(CourseTemplate $opleidingssoort)
    {
        $this->opleidingssoort = $opleidingssoort;
    }

    public function getByCode(string $code): ?Opleiding
    {
        $params = $this->makeParams(['where' => 'code='.$code]);
        $data = $this->coachview->getData('/api/v1/Opleidingen', $params);

        foreach ($data as $coachViewCourse) {
            return $this->getCourseFromCoachViewData($coachViewCourse);
        }

        return null;
    }
}
