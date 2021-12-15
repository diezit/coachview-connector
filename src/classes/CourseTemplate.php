<?php

namespace Diezit\CoachviewConnector\Classes;

use Carbon\Carbon;
use Diezit\CoachviewConnector\Coachview;
use Illuminate\Support\Collection;

class CourseTemplate extends CoachviewData
{
    protected $id;
    protected $name;
    protected $code;
    protected $publishOnWebsite;
    protected $isInactive;
    protected $comments;

    public function all($offset = null, $limit = null): Collection
    {
        $params = $this->makeParams(['skip' => $offset, 'take' => $limit]);
        $data = $this->coachview->getData('/api/v1/Opleidingssoorten', $params);


        $response = [];
        foreach ($data as $coachViewCourseTemplate) {
            $response[] = $this->getCourseTemplateFromCoachViewData($coachViewCourseTemplate);
        }

        return collect($response);
    }

    public function getCourseTemplateFromCoachViewData($coachViewCourseTemplate): CourseTemplate
    {
        return (new CourseTemplate($this->coachview))
            ->setId($coachViewCourseTemplate->id)
            ->setName($coachViewCourseTemplate->naam)
            ->setCode($coachViewCourseTemplate->code)
            ->setPublishOnWebsite($coachViewCourseTemplate->publicatieWebsite)
            ->setIsInactive($coachViewCourseTemplate->inactief)
            ->setComments($coachViewCourseTemplate->opmerking);
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

    public function getPublishOnWebsite(): bool
    {
        return $this->publishOnWebsite;
    }

    public function setPublishOnWebsite(bool $status): self
    {
        $this->publishOnWebsite = $status;
        return $this;
    }

    public function getIsInactive(): bool
    {
        return $this->isInactive;
    }

    public function setIsInactive(bool $status): self
    {
        $this->isInactive = $status;
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

    public function getByCode(string $code): ?CourseTemplate
    {
        $params = $this->makeParams(['where' => 'code='.$code]);
        $data = $this->coachview->getData('/api/v1/Opleidingssoorten', $params);

        foreach ($data as $coachViewCourseTemplate) {
            return $this->getCourseTemplateFromCoachViewData($coachViewCourseTemplate);
        }

        return null;
    }


}
