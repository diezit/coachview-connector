<?php

namespace Diezit\CoachviewConnector\Interfaces;

interface AdresInterface
{
    public function getAdres1(): ?string;

    public function getAdres2(): ?string;

    public function getAdres3(): ?string;

    public function getAdres4(): ?string;

    public function getPostcode(): ?string;

    public function getPlaats(): ?string;

    public function getLandCode(): ?string;
}
