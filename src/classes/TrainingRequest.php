<?php

namespace Diezit\CoachviewConnector\Classes;

class TrainingRequest extends CoachviewData
{
    protected $reference;
    protected $comments;
    protected $numberOfParticipants;
    protected $company;
    protected $contactPerson;
    protected $debtor;
    protected $participants = [];
    protected $courses;

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @param  string  $reference
     */
    public function setReference(string $reference): void
    {
        $this->reference = $reference;
    }

    /**
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param  string  $comments
     */
    public function setComments(string $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @return int
     */
    public function getNumberOfParticipants(): int
    {
        return $this->numberOfParticipants;
    }

    /**
     * @param  int  $numberOfParticipants
     */
    public function setNumberOfParticipants(int $numberOfParticipants): void
    {
        $this->numberOfParticipants = $numberOfParticipants;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param  mixed  $company
     */
    public function setCompany($company): void
    {
        $this->company = $company;
    }

    /**
     * @return mixed
     */
    public function getDebtor()
    {
        return $this->debtor;
    }

    /**
     * @param  Debtor  $debtor
     */
    public function setDebtor(Debtor $debtor): void
    {
        $this->debtor = $debtor;
    }

    /**
     * @return mixed
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * @param  mixed  $courses
     */
    public function setCourses($courses): void
    {
        $this->courses = $courses;
    }


    public function addParticipant(Person $person)
    {
        $this->participants[] = $person;
    }

    public function setContactPerson(Person $person)
    {
        $this->contactPerson = $person;
    }

    public function store()
    {
//        dd($this->getSoapRequest());
//        Soap::to('https://secure.coachview.net/Webservice/speciaal.asmx?WSDL')->call('ToevoegenWebAanvraagV2', [
//            'aWebserviceAuthentication' => $this->coachview->getSoapApiKey(),
//            'aWebAanvraag' => $this->getSoapRequest()
//        ]);
//        dd('storing!');
    }

    /**
     * @return string containing XML data
     */
    private function getSoapRequest(): string
    {
//        $xml = new \SimpleXMLElement('<WebAanvraag/>');
//        $onderdelen = $xml->addAttribute('WebAanvraagOnderdelen');
//        $onderdeel = $onderdelen->addAttribute('WebAanvraagOnderdeel');
//        $onderdeel->addAttribute('Code', 'AVV1965.D1.PL-1');
//        $onderdeel->addAttribute('Naam', 'test');
//
//        dd($xml);
    }
}
