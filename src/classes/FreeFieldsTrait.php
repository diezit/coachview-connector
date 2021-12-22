<?php

namespace Diezit\CoachviewConnector\Classes;

use Diezit\CoachviewConnector\Coachview;

trait FreeFieldsTrait
{
    /**
     * @return array|FreeField[]
     */
    public function getFreeFields(string $endpoint): array
    {
        $coachView = $this->getCoachview();
        $params = $this->makeParams(['where' => 'recordId='.$this->getId()]);
        $coachViewData = $coachView->getData($endpoint, $params);
        $freeFields = [];
        foreach ($coachViewData as $freeField) {
            $freeFields[] = (new FreeField($coachView))
                ->setOrder($freeField->vrijveldDefinitie->volgorde)
                ->setCode($freeField->vrijveldDefinitie->code)
                ->setLabel($freeField->vrijveldDefinitie->label)
                ->setType($freeField->vrijveldDefinitie->vrijveldTypeId)
                ->setExpression($freeField->vrijveldDefinitie->expressie)
                ->setInactive($freeField->vrijveldDefinitie->inactief)
                ->setConfidential($freeField->vrijveldDefinitie->vertrouwelijk)
                ->setData($freeField->data);
        }
        return $freeFields;
    }

    protected abstract function getId();

    protected abstract function makeParams(array $options): array;

    public abstract function getCoachview(): Coachview;
}
