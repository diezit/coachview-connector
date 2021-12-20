<?php

namespace Diezit\CoachviewConnector\Interfaces;

interface WebAanvraagInterface
{

    public function getReferentieNrKlant();

    public function getOpmerking();

    public function getAantalPersonen();

    public function getUitvoeringstermijn();

    public function getAanvraagIsOrder();

    public function getVrijevelden();

    public function getBedrijf();

    public function getContactpersoon();

    public function getContactpersoonIsLeidinggevende();

    public function getAutorisatieEigenaar();

    public function getDebiteur();

    public function getDeelnemers();

    public function getOpleidingen();


}