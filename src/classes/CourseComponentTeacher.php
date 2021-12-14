<?php


namespace Diezit\Coachview\Service\Classes;


class CourseComponentTeacher extends CoachviewData
{
    protected $courseComponentId;
    protected $teacherId;
    protected $teacherRoleId;
    protected $planningStatus;
    protected $comments;

    public function getForCourseComponent($courseComponentId)
    {
        $skip = 0;
        $take = 100;

        $response = [];
        $running = true;

        while ($running) {
            $params = $this->makeParams(['where' => 'opleidingsonderdeelId=' . $courseComponentId, 'take' => $take, 'skip' => $skip]);
            $data = $this->coachview->getData('/api/v1/Opleidingsonderdelen_Docenten', $params);
            foreach ($data as $coachViewCourseComponent) {
                $response[] = $this->getCourseComponentTeacherFromCoachViewData($coachViewCourseComponent);
            }

            $skip += $take;
            if (count($data) < $take) {
                $running = false;
            }
        }

        return collect($response);
    }

    private function getCourseComponentTeacherFromCoachViewData($coachViewData): CourseComponentTeacher
    {
        return (new CourseComponentTeacher($this->coachview))
            ->setCourseComponentId($coachViewData->opleidingsonderdeelId)
            ->setTeacherId($coachViewData->docentId)
            ->setTeacherRoleId($coachViewData->docentrolId)
            ->setPlanningStatus($coachViewData->planningsstatus)
            ->setComments($coachViewData->toelichting);
    }

    public function getCourseComponentId()
    {
        return $this->courseComponentId;
    }

    public function setCourseComponentId($courseComponentId): CourseComponentTeacher
    {
        $this->courseComponentId = $courseComponentId;
        return $this;
    }

    public function getTeacherId()
    {
        return $this->teacherId;
    }

    public function setTeacherId($teacherId): CourseComponentTeacher
    {
        $this->teacherId = $teacherId;
        return $this;
    }

    public function getTeacherRoleId()
    {
        return $this->teacherRoleId;
    }

    public function setTeacherRoleId($teacherRoleId): CourseComponentTeacher
    {
        $this->teacherRoleId = $teacherRoleId;
        return $this;
    }

    public function getPlanningStatus()
    {
        return $this->planningStatus;
    }

    public function setPlanningStatus($planningStatus): CourseComponentTeacher
    {
        $this->planningStatus = $planningStatus;
        return $this;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments($comments): CourseComponentTeacher
    {
        $this->comments = $comments;
        return $this;
    }


}
