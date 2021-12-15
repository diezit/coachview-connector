<?php

namespace Diezit\CoachviewConnector\Classes;

use Illuminate\Support\Collection;

class CourseComponent extends CoachviewData
{
    protected $id;
    protected $code;
    protected $name;
    protected $description;
    protected $date;
    protected $startTime;
    protected $endTime;
    protected $studyCredits;
    protected $maxAttendees;
    protected $attendees;
    protected $location;
    protected $teacher;
    protected $template;

    public function where($column, $value)
    {
        $params = $this->makeParams(['where' => $column.'='.$value]);
        return $this->coachview->getData('/api/v1/Opleidingsonderdelen', $params);
    }

    public function getForCourse($courseId)
    {
        $skip = 0;
        $take = 100;

        $response = [];
        $running = true;

        while ($running) {
            $params = $this->makeParams(['where' => 'opleidingId='.$courseId, 'take' => $take, 'skip' => $skip]);
            $data = $this->coachview->getData('/api/v1/Opleidingsonderdelen', $params);
            foreach ($data as $coachViewCourseComponent) {
                $response[] = $this->getCourseComponentFromCoachViewData($coachViewCourseComponent);
            }

            $skip += $take;
            if (count($data) < $take) {
                $running = false;
            }
        }

        return collect($response);
    }

    private function getCourseComponentFromCoachViewData($coachViewCourseComponent): CourseComponent
    {
        $courseComponent = (new CourseComponent($this->coachview))
            ->setId($coachViewCourseComponent->id)
            ->setName($coachViewCourseComponent->naam)
            ->setCode($coachViewCourseComponent->code)
            ->setDescription($coachViewCourseComponent->omschrijving)
            ->setDate($coachViewCourseComponent->datum)
            ->setStartTime($coachViewCourseComponent->tijdVan)
            ->setEndTime($coachViewCourseComponent->tijdTot)
            ->setStudyCredits($coachViewCourseComponent->studiebelasting)
            ->setAttendees($coachViewCourseComponent->maxCursisten - $coachViewCourseComponent->aantalVrij)
            ->setMaxAttendees($coachViewCourseComponent->maxCursisten);

        if ($coachViewCourseComponent->opleidingssoortonderdeelId) {
            $template = (new CourseComponentTemplate($this->coachview))
                ->getCourseComponentTemplateFromCoachViewData($coachViewCourseComponent->opleidingssoortOnderdeel);
            $courseComponent->setTemplate($template);
        }

        if ($coachViewCourseComponent->locatie->lokaal) {
            $courseComponent->setLocation($coachViewCourseComponent->locatie->lokaal);
        } elseif ($coachViewCourseComponent->locatie->bedrijf->naam) {
            $courseComponent->setLocation($coachViewCourseComponent->locatie->bedrijf->naam);
        }

        return $courseComponent;
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

    public function __get($key)
    {
        switch ($key) {
            case 'teachers':
                return $this->teachers();
        }
    }

    public function getTemplate(): ?CourseComponentTemplate
    {
        return $this->template;
    }

    private function setTemplate(CourseComponentTemplate $template)
    {
        $this->template = $template;
    }

    /**
     * @return array|FreeField[]
     */
    public function getFreeFields(): array
    {
        $params = $this->makeParams(['where' => 'recordId='.$this->id]);
        $coachViewData = $this->coachview->getData('/api/v1/Opleidingsonderdelen/Vrijevelden', $params);
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
