<?php

namespace Diezit\CoachviewConnector\Classes;

use Diezit\CoachviewConnector\Coachview;

class CoachviewData
{
    protected $coachview;

    public function __construct(Coachview $coachview)
    {
        $this->coachview = $coachview;
        return $this;
    }

    public function makeParams($options)
    {
        foreach ($options as $key => $value) {
            if ($value == null || $value = '') {
                unset($options[$key]);
            }
        }
        return $options;
    }
}
