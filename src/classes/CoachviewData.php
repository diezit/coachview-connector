<?php

namespace Diezit\CoachviewConnector\Classes;

use Diezit\CoachviewConnector\Coachview;

class CoachviewData
{
    protected $coachview;

    public function __construct(Coachview $coachview)
    {
        $this->coachview = $coachview;
    }

    public function getCoachview(): Coachview
    {
        return $this->coachview;
    }

    public function makeParams(array $options): array
    {
        return array_filter($options);
    }
}
