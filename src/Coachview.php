<?php

namespace Diezit\CoachviewConnector;

use Cache;
use Diezit\CoachviewConnector\Classes\Course;
use Diezit\CoachviewConnector\Classes\CourseComponent;
use Diezit\CoachviewConnector\Classes\CourseComponentTeacher;
use Diezit\CoachviewConnector\Classes\Teacher;
use Diezit\CoachviewConnector\Classes\TrainingRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class Coachview
{
    const CACHE_KEY_ACCESS_TOKEN = 'coachview_access_token';

    /** @var string */
    private $apiRoot;

    /** @var string */
    private $clientId;

    /** @var string */
    private $secret;

    /** @var Client */
    private $client;

    public function __construct(string $apiRoot, string $clientId, string $secret)
    {
        $this->apiRoot = $apiRoot;
        $this->clientId = $clientId;
        $this->secret = $secret;

        $this->client = new Client();
    }

    public function getData(string $endpoint, array $params = null): ?array
    {
        try {
            $response = $this->doRequest($endpoint, $params);
            if (!$response) {
                return null;
            }
            if ($response->getStatusCode() === 401) {
                $this->refreshAccessToken();
                $response = $this->doRequest($endpoint, $params);
            }
            return json_decode((string)$response->getBody());
        } catch (RequestException $exception) {
            // @TODO: remove below Exception when going live. This is to make errors more verbose while testing.
            dd($exception);
            return null;
        }
    }

    public function doRequest(string $endpoint, array $params = null): ?ResponseInterface
    {
        try {
            return $this->client->request(
                'GET',
                $this->apiRoot.$endpoint,
                [
                    'query' => $params,
                    'headers' => [
                        'Authorization' => 'Bearer '.$this->getAccessToken()
                    ]
                ]
            );
        } catch (RequestException $exception) {
            // @TODO: remove below Exception when going live. This is to make errors more verbose while testing.
            if (!app()->environment('production')) {
                dd($exception);
            }
            return null;
        }
    }

    private function getAccessToken(): ?string
    {
        if (!Cache::has(self::CACHE_KEY_ACCESS_TOKEN)) {
            $this->refreshAccessToken();
        }

        return Cache::get(self::CACHE_KEY_ACCESS_TOKEN);
    }

    protected function refreshAccessToken(): void
    {
        try {
            $tokenRequest = $this->client->request(
                'POST',
                $this->apiRoot.'/auth/connect/token',
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
                            'Webaanvragen.Schrijven'
                        ]),
                    ]
                ]
            );
        } catch (RequestException $exception) {
            throw new \Exception('Unable to retrieve authentication token: '.$exception->getMessage());
        }

        $tokenResponseBody = (string)$tokenRequest->getBody();
        $tokenData = json_decode($tokenResponseBody);

        Cache::put(self::CACHE_KEY_ACCESS_TOKEN, $tokenData->access_token, $tokenData->expires_in);
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
