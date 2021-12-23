<?php

namespace Diezit\CoachviewConnector\interfaces;

interface OpleidingssoortInterface
{
    public function getId(): ?string;

    public function getCode(): ?string;

    public function getNaam(): ?string;

    public function getDoel(): ?string;

    public function getDoelgroep(): ?string;

    public function getVooropleiding(): ?string;

    public function getOmschrijvingInhoud(): ?string;

    public function getOpmerking(): ?string;

    public function getPublicatieWebsite(): ?bool;

    public function getInactief(): ?bool;

    public function getPrijsExclBtw(): ?float;

    public function getCategorieen(): array;
}
