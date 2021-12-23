<?php

namespace Diezit\CoachviewConnector\Interfaces;

use Carbon\Carbon;

interface OpleidingsonderdeelInterface
{
    public function getId(): ?string;

    public function getCode(): ?string;

    public function getNaam(): ?string;

    public function getOmschrijving(): ?string;

    public function getStartDatum(): ?Carbon;

    public function getEindDatum(): ?Carbon;

    public function getLocatie(): ?string;

    public function getOpleiding(): ?OpleidingInterface;

    public function getDetails(): self;
}
