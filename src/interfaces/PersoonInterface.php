<?php

namespace Diezit\CoachviewConnector\Interfaces;

interface PersoonInterface
{
    public function getId();

    public function getTitel();

    public function getVoorletters();

    public function getVoornaam();

    public function getTussenvoegsels();

    public function getAchternaam();

    public function getAchterTitel();

    public function getAdres();

    public function getFactuurAdres();

    public function getEmailAdres();

    public function getTelefoonNummer();

    public function getGeslacht();

    public function getGeboorteDatum();

}