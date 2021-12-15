<?php

namespace Diezit\CoachviewConnector;

use Carbon\Carbon;
use Diezit\Coachview\Service\Classes\Course;
use Diezit\Coachview\Service\Classes\CourseComponent;
use Diezit\Coachview\Service\Classes\CourseComponentTeacher;
use Diezit\Coachview\Service\Classes\Teacher;
use Diezit\Coachview\Service\Classes\TrainingRequest;
use GuzzleHttp\Exception\RequestException;

class Coachview
{

    private $apiRoot;
    private $clientId;
    private $secret;
    private $accessToken;
    private $accessTokenExpiry;
    private $soapApiKey;

    public function __construct($apiRoot, $clientId, $secret, $soapApiKey)
    {
        $this->apiRoot = $apiRoot;
        $this->clientId = $clientId;
        $this->secret = $secret;
        $this->soapApiKey = $soapApiKey;

        $this->client = new \GuzzleHttp\Client();

        return $this;
    }

    public function getSoapApiKey(): string
    {
        return $this->soapApiKey;
    }

    public function getData($endpoint, $params = null): ?array
    {
        try {
            $response = $this->client->request('GET', $this->apiRoot.$endpoint,
                [
                    'query' => $params,
                    'headers'  => [
                        'Authorization' => 'Bearer '.$this->getAccessToken()
                    ]
                ]
            );
            return json_decode((string)$response->getBody());
        } catch(RequestException $exception) {
            // @TODO: remove below Exception when going live. This is to make errors more verbose while testing.
            dd($exception);
            return null;
        }
    }

    private function getAccessToken(): ?string
    {
        if ($this->accessToken && $this->accessTokenExpiry > Carbon::now()) {
            return $this->accessToken;
        }
        try {
            $tokenRequest = $this->client->request('POST', $this->apiRoot.'/auth/connect/token',
               [
                   'form_params' => [
                       'client_id' => $this->clientId,
                       'grant_type' => 'client_credentials',
                       'client_secret' => $this->secret,
                       'scope' => implode(' ', [
                           'api',
                           'Opleidingen.Lezen',
                           'Opleidingsonderdelen.Lezen',
                           'Opleidingsonderdelen_Docenten.Lezen',
                           'Opleidingssoortonderdelen.Lezen',
                           'Docenten.Lezen',
                       ]),
                   ]
               ]
            );
        } catch(RequestException $exception) {
            throw new \Exception('Unable to retrieve authentication token: ' . $exception->getMessage());
        }

        $tokenResponseBody = (string)$tokenRequest->getBody();
        $tokenData = json_decode($tokenResponseBody);

        $this->accessToken = $tokenData->access_token;
        $this->accessTokenExpiry = Carbon::now()->addSeconds($tokenData->expires_in);

        return $this->accessToken;
    }

    public function course(): Course
    {
        return new Course($this);
    }

    public function courseComponent(): CourseComponent
    {
        return new CourseComponent($this);
    }

    public function courseComponentTeacher(): CourseComponentTeacher
    {
        return new CourseComponentTeacher($this);
    }

    public function trainingRequest(): TrainingRequest
    {
        return new TrainingRequest($this);
    }

    public function teacher(): Teacher
    {
        return new Teacher($this);
    }
}
