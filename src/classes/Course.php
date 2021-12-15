<?php

namespace Diezit\CoachviewConnector\Classes;

use Carbon\Carbon;
use Diezit\CoachviewConnector\Coachview;
use Illuminate\Support\Collection;

class Course extends CoachviewData
{
    protected $id;
    protected $name;
    protected $code;
    protected $status;
    protected $planningStatus;
    protected $comments;
    protected $location;
    protected $contactPerson;
    protected $startDate;
    protected $endDate;
    protected $attendees;
    protected $template;
    protected $maxAttendees;
    protected $study_credits;

    public function all($offset = null, $limit = null): Collection
    {
        $params = $this->makeParams(['skip' => $offset, 'take' => $limit]);
        $data = $this->coachview->getData('/api/v1/Opleidingen', $params);


        $response = [];
        foreach ($data as $coachViewCourse) {
            $response[] = $this->getCourseFromCoachViewData($coachViewCourse);
        }

        return collect($response);
    }

    private function getCourseFromCoachViewData($coachViewCourse): Course
    {
        $course = (new Course($this->coachview))
            ->setId($coachViewCourse->id)
            ->setName($coachViewCourse->naam)
            ->setCode($coachViewCourse->code)
            ->setStatus($coachViewCourse->publicatie)
            ->setPlanningStatus($coachViewCourse->publicatiePlanning)
            ->setComments($coachViewCourse->opmerking)
            ->setStartDate($coachViewCourse->startDatum)
            ->setEndDate($coachViewCourse->eindDatum)
            ->setAttendees($coachViewCourse->aantalPlaatsenBezet)
            ->setMaxAttendees($coachViewCourse->aantalPlaatsenMax);

        if ($coachViewCourse->startLocatie) {
            $course->setLocation($coachViewCourse->startLocatie->lokaal);
        }

        if ($coachViewCourse->opleidingssoortId) {
            $template = (new CourseTemplate($this->coachview))
                ->getCourseTemplateFromCoachViewData($coachViewCourse->opleidingssoort);
            $course->setTemplate($template);
        }

        return $course;
    }

    /**
     * @return Collection|CourseComponent
     */
    public function components(): Collection
    {
        return $this->coachview->courseComponent()->getForCourse($this->id);
    }

    public function __get($key)
    {
        switch ($key) {
            case 'components':
                return $this->components();
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getPlanningStatus()
    {
        return $this->planningStatus;
    }

    public function setPlanningStatus($planningStatus): self
    {
        $this->planningStatus = $planningStatus;
        return $this;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments($comments): self
    {
        $this->comments = $comments;
        return $this;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getContactPerson(): Person
    {
        return $this->contactPerson;
    }

    public function setContactPerson(Person $contactPerson): self
    {
        $this->contactPerson = $contactPerson;
        return $this;
    }

    public function getStartDate(): Carbon
    {
        return $this->startDate;
    }

    public function setStartDate($startDate): self
    {
        $this->startDate = new Carbon($startDate);
        return $this;
    }

    public function getEndDate(): Carbon
    {
        return $this->endDate;
    }

    public function setEndDate($endDate): self
    {
        $this->endDate = new Carbon($endDate);
        return $this;
    }

    public function getAttendees()
    {
        return $this->attendees;
    }

    public function setAttendees($attendees): self
    {
        $this->attendees = $attendees;
        return $this;
    }

    public function getMaxAttendees()
    {
        return $this->places;
    }

    public function setMaxAttendees($attendees): self
    {
        $this->maxAttendees = $attendees;
        return $this;
    }

    public function getStudyCredits()
    {
        return $this->study_credits;
    }

    public function setStudyCredits($study_credits): self
    {
        $this->study_credits = $study_credits;
        return $this;
    }

    public function getTemplate(): ?CourseTemplate
    {
        return $this->template;
    }

    private function setTemplate(CourseTemplate $template)
    {
        $this->template = $template;
    }

    public function getByCode(string $code): ?Course
    {
        $params = $this->makeParams(['where' => 'code='.$code]);
        $data = $this->coachview->getData('/api/v1/Opleidingen', $params);

        foreach ($data as $coachViewCourse) {
            return $this->getCourseFromCoachViewData($coachViewCourse);
        }

        return null;
    }


}
