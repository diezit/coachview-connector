<?php

namespace Diezit\CoachviewConnector\Classes;

use Carbon\Carbon;
use Diezit\CoachviewConnector\Coachview;
use Illuminate\Support\Collection;

class Opleidingssoort extends CoachviewData
{
    protected $id;
    protected $code;
    protected $naam;
    protected $doel;
    protected $doelgroep;
    protected $vooropleiding;
    protected $omschrijvingInhoud;
    protected $opmerking;
    protected $publicatieWebsite;
    protected $inactief;

    public function all($offset = null, $limit = null): Collection
    {
        $params = $this->makeParams(['skip' => $offset, 'take' => $limit]);
        $data = $this->coachview->getData('/api/v1/Opleidingssoorten', $params);


        $response = [];
        foreach ($data as $coachViewCourseTemplate) {
            $response[] = $this->getCourseTemplateFromCoachViewData($coachViewCourseTemplate);
        }

        return collect($response);
    }

    public function getCourseTemplateFromCoachViewData($coachViewCourseTemplate): Opleidingssoort
    {
        return (new Opleidingssoort($this->coachview))
            ->setId($coachViewCourseTemplate->id)
            ->setCode($coachViewCourseTemplate->code)
            ->setNaam($coachViewCourseTemplate->naam)
            ->setDoel($coachViewCourseTemplate->doel)
            ->setDoelgroep($coachViewCourseTemplate->doelgroep)
            ->setVooropleiding($coachViewCourseTemplate->vooropleiding)
            ->setOmschrijvingInhoud($coachViewCourseTemplate->omschrijvingInhoud)
            ->setOpmerking($coachViewCourseTemplate->opmerking)
            ->setPublicatieWebsite($coachViewCourseTemplate->publicatieWebsite)
            ->setInactief($coachViewCourseTemplate->inactief);
    }

    public function getByCode(string $code): ?Opleidingssoort
    {
        $params = $this->makeParams(['where' => 'code='.$code]);
        $data = $this->coachview->getData('/api/v1/Opleidingssoorten', $params);

        foreach ($data as $coachViewCourseTemplate) {
            return $this->getCourseTemplateFromCoachViewData($coachViewCourseTemplate);
        }

        return null;
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getNaam(): ?string
    {
        return $this->naam;
    }

    public function setNaam(?string $naam): self
    {
        $this->naam = $naam;
        return $this;
    }

    public function getDoel(): ?string
    {
        return $this->doel;
    }

    public function setDoel(?string $doel): self
    {
        $this->doel = $doel;
        return $this;
    }

    public function getDoelgroep(): ?string
    {
        return $this->doelgroep;
    }

    public function setDoelgroep(?string $doelgroep): self
    {
        $this->doelgroep = $doelgroep;
        return $this;
    }

    public function getVooropleiding(): ?string
    {
        return $this->vooropleiding;
    }

    public function setVooropleiding(?string $vooropleiding): self
    {
        $this->vooropleiding = $vooropleiding;
        return $this;
    }

    public function getOmschrijvingInhoud(): ?string
    {
        return $this->omschrijvingInhoud;
    }

    public function setOmschrijvingInhoud(?string $omschrijvingInhoud): self
    {
        $this->omschrijvingInhoud = $omschrijvingInhoud;
        return $this;
    }

    public function getOpmerking(): ?string
    {
        return $this->opmerking;
    }

    public function setOpmerking(?string $opmerking): self
    {
        $this->opmerking = $opmerking;
        return $this;
    }

    public function getPublicatieWebsite(): ?bool
    {
        return $this->publicatieWebsite;
    }

    public function setPublicatieWebsite(bool $publicatieWebsite): self
    {
        $this->publicatieWebsite = $publicatieWebsite;
        return $this;
    }

    public function getInactief(): ?bool
    {
        return $this->inactief;
    }

    public function setInactief(bool $inactief): self
    {
        $this->inactief = $inactief;
        return $this;
    }

}
