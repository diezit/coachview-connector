<?php

namespace Diezit\CoachviewConnector\Classes;

class TrainingRequest extends CoachviewData
{
    protected $reference;
    protected $comments;
    protected $executionTime;
    protected $isOrder = false;
    protected $company;
    protected $contactPerson;
    protected $debtor;
    protected $participants = [];
    protected $courses;

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): void
    {
        $this->reference = $reference;
    }

    public function getExecutionTime(): ?string
    {
        return $this->executionTime;
    }

    public function setExecutionTime(string $executionTime): self
    {
        $this->executionTime = $executionTime;
        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(string $comments): void
    {
        $this->comments = $comments;
    }

    public function getNumberOfParticipants(): int
    {
        return count($this->participants);
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;
        return $this;
    }

    public function getIsOrder(): bool
    {
        return $this->isOrder;
    }

    public function setIsOrder(bool $isOrder): self
    {
        $this->isOrder = $isOrder;
        return $this;
    }

    public function getDebtor()
    {
        return $this->debtor;
    }

    public function setDebtor(Debtor $debtor): self
    {
        $this->debtor = $debtor;
        return $this;
    }

    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * @param  mixed  $courseId  CoachView ID of course
     */
    public function addCourse(string $courseId): self
    {
        $this->courses[] = $courseId;
        return $this;
    }

    public function addParticipant(Person $person): self
    {
        $this->participants[] = $person;
        return $this;
    }

    public function setContactPerson(Person $person)
    {
        $this->contactPerson = $person;
    }

    public function getContactPerson()
    {
        return $this->contactPerson;
    }

    public function submit()
    {
        $courses = [];
        foreach ($this->courses as $courseId) {
            $courses[] = (object)[
                'opleidingId' => $courseId
            ];
        }

        $postData = [
            'referentieNrKlant' => $this->getReference(),
            'opmerking' => $this->getComments(),
            'aantalPersonen' => $this->getNumberOfParticipants(),
            'uitvoeringstermijn' => $this->getExecutionTime(),
            'aanvraagIsOrder' => $this->getIsOrder(),
            'opleidingen' => $courses,
            'contactpersoon' => $this->getContactPerson(),
        ];

        dd($postData);

        $this->coachview->postData('/api/v1/Webaanvragen', $postData);
    }
}
