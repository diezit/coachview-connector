<?php

namespace Diezit\CoachviewConnector\Classes;

use Illuminate\Support\Collection;

class CourseComponentTemplate extends CoachviewData
{
    protected $id;
    protected $code;
    protected $name;
    protected $description;
    protected $hours;
    protected $startTime;
    protected $endTime;
    protected $studyCredits;
    protected $minAttendees;
    protected $maxAttendees;
    protected $inactive;
    protected $exam;

    public function where($column, $value)
    {
        $params = $this->makeParams(['where' => $column.'='.$value]);
        return $this->coachview->getData('/api/v1/Opleidingssoortonderdelen', $params);
    }

    public function getCourseComponentTemplateFromCoachViewData($coachViewCourseComponentTemplate
    ): CourseComponentTemplate {
        return (new CourseComponentTemplate($this->coachview))
            ->setId($coachViewCourseComponentTemplate->id)
            ->setName($coachViewCourseComponentTemplate->naam)
            ->setCode($coachViewCourseComponentTemplate->code)
            ->setDescription($coachViewCourseComponentTemplate->omschrijvingInhoud)
            ->setHours($coachViewCourseComponentTemplate->aantalUur)
            ->setStartTime($coachViewCourseComponentTemplate->tijdVan)
            ->setEndTime($coachViewCourseComponentTemplate->tijdTot)
            ->setStudyCredits($coachViewCourseComponentTemplate->studiebelasting)
            ->setMinAttendees($coachViewCourseComponentTemplate->minCursisten)
            ->setInactive($coachViewCourseComponentTemplate->inactief)
            ->setExam($coachViewCourseComponentTemplate->examen)
            ->setMaxAttendees($coachViewCourseComponentTemplate->maxCursisten);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
        return $this;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
        return $this;
    }

    public function getStudyCredits()
    {
        return $this->studyCredits;
    }

    public function setStudyCredits($studyCredits)
    {
        $this->studyCredits = $studyCredits;
        return $this;
    }

    public function getMaxAttendees()
    {
        return $this->maxAttendees;
    }

    public function setMaxAttendees($maxAttendees)
    {
        $this->maxAttendees = $maxAttendees;
        return $this;
    }

    public function getAttendees()
    {
        return $this->attendees;
    }

    public function setAttendees($attendees)
    {
        $this->attendees = $attendees;
        return $this;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return Collection|CourseComponentTeacher
     */
    public function teachers(): Collection
    {
        return $this->coachview->courseComponentTeacher()->getForCourseComponent($this->id);
    }

    public function getHours()
    {
        return $this->hours;
    }

    public function setHours($hours)
    {
        $this->hours = $hours;
        return $this;
    }

    public function getMinAttendees()
    {
        return $this->minAttendees;
    }

    public function setMinAttendees($minAttendees)
    {
        $this->minAttendees = $minAttendees;
        return $this;
    }

    public function getInactive()
    {
        return $this->inactive;
    }

    public function setInactive($inactive)
    {
        $this->inactive = $inactive;
        return $this;
    }

    public function getExam()
    {
        return $this->exam;
    }

    public function setExam($exam)
    {
        $this->exam = $exam;
        return $this;
    }

    /**
     * @return array|FreeField[]
     */
    public function getFreeFields(): array
    {
        $params = $this->makeParams(['where' => 'recordId='.$this->id]);
        $coachViewData = $this->coachview->getData('/api/v1/Opleidingssoortonderdelen/Vrijevelden', $params);
        $freeFields = [];
        foreach ($coachViewData as $freeField) {
            $freeFields[] = (new FreeField($this->coachview))
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

}
