<?php

namespace Diezit\CoachviewConnector\Interfaces;

use Carbon\Carbon;

interface OpleidingInterface
{
    public function getId(): ?string;

    public function getNaam();

    public function getCode();

    public function getPublicatie(): ?bool;

    public function getPublicatiePlanning(): ?bool;

    public function getOpmerking();

    public function getStartLocatie();

    public function getContactPersoon(): ?PersoonInterface;

    public function getStartDatum(): Carbon;

    public function getEindDatum(): Carbon;

    public function getAantalPlaatsenBezet();

    public function getAantalPlaatsenMax();

    public function getOpleidingssoort(): ?OpleidingssoortInterface;

    public function getStudiePunten(): ?int;
}
