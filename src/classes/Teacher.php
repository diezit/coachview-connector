<?php


namespace Diezit\Coachview\Service\Classes;

use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\This;

class Teacher extends CoachviewData
{
    protected $id;
    protected $initials;
    protected $firstName;
    protected $lastNamePrefix;
    protected $lastName;
    protected $gender;
    protected $email;
    protected $companyName;
    protected $jobTitle;

    public function all($offset = null, $limit = null): Collection
    {
        $params = $this->makeParams(['skip'=> $offset, 'take' => $limit]);
        $data = $this->coachview->getData('/api/v1/Docenten', $params);

        $response = [];
        foreach ($data as $coachViewTeacher) {
            $response[] = $this->getTeacherFromCoachViewData($coachViewTeacher);
        }

        return collect($response);
    }

    private function getTeacherFromCoachViewData($coachViewTeacher): Teacher
    {
        return (new Teacher($this->coachview))
            ->setId($coachViewTeacher->id)
            ->setInitials($coachViewTeacher->voorletters)
            ->setFirstName($coachViewTeacher->voornaam)
            ->setLastNamePrefix($coachViewTeacher->tussenvoegsels)
            ->setLastName($coachViewTeacher->achternaam)
            ->setGender($coachViewTeacher->geslacht)
            ->setEmail($coachViewTeacher->email1)
            ->setCompanyName($coachViewTeacher->bedrijfsnaam)
            ->setJobTitle($coachViewTeacher->functie);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Teacher
    {
        $this->id = $id;
        return $this;
    }

    public function getInitials(): ?string
    {
        return $this->initials;
    }

    public function setInitials(?string $initials): Teacher
    {
        $this->initials = $initials;
        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): Teacher
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastNamePrefix(): ?string
    {
        return $this->lastNamePrefix;
    }

    public function setLastNamePrefix(?string $lastNamePrefix): Teacher
    {
        $this->lastNamePrefix = $lastNamePrefix;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): Teacher
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): Teacher
    {
        $this->gender = $gender;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): Teacher
    {
        $this->email = $email;
        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): Teacher
    {
        $this->companyName = $companyName;
        return $this;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(?string $jobTitle): Teacher
    {
        $this->jobTitle = $jobTitle;
        return $this;
    }


}
