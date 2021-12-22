<?php

namespace Diezit\CoachviewConnector;

use Cache;
use Diezit\CoachviewConnector\Classes\Opleiding;
use Diezit\CoachviewConnector\Classes\CourseComponent;
use Diezit\CoachviewConnector\Classes\CourseComponentTeacher;
use Diezit\CoachviewConnector\Classes\Opleidingssoort;
use Diezit\CoachviewConnector\Classes\Persoon;
use Diezit\CoachviewConnector\Classes\Teacher;
use Diezit\CoachviewConnector\Classes\WebAanvraag;
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

    /**
     * @return array|object|null
     */
    public function getData(string $endpoint, array $params = null)
    {
        $response = $this->doRequest($endpoint, 'GET', $params);
        if (!$response) {
            return null;
        }

        return json_decode((string)$response->getBody());
    }

    public function doRequest(string $endpoint, string $method, array $params = null, bool $isRetrying = false): ?ResponseInterface
    {
        try {
            $dataType = $method == 'GET' ? 'query' : 'json';
            return $this->client->request(
                $method,
                $this->apiRoot.$endpoint,
                [
                    $dataType => $params,
                    'headers' => [
                        'Authorization' => 'Bearer '.$this->getAccessToken()
                    ]
                ]
            );
        } catch (RequestException $exception) {
            // try once more if code is 401 (unauthorized)
            if ($exception->getCode() === 401 && !$isRetrying) {
                $this->refreshAccessToken();
                return $this->doRequest($endpoint, $method, $params, true);
            }

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
                            'Opleidingssoorten.Lezen',
                            'Opleidingsonderdelen.Lezen',
                            'Opleidingsonderdelen_Docenten.Lezen',
                            'Opleidingssoortonderdelen.Lezen',
                            'Opleidingssoorten_Verkoopregels.Lezen',
                            'Verkoopregels.Lezen',
                            'Docenten.Lezen',
                            'Webaanvragen.Schrijven',
                            'Personen.Lezen',
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

    public function opleiding(): Opleiding
    {
        return new Opleiding($this);
    }

    public function opleidingssoort(): Opleidingssoort
    {
        return new Opleidingssoort($this);
    }

    public function courseComponent(): CourseComponent
    {
        return new CourseComponent($this);
    }

    public function courseComponentTeacher(): CourseComponentTeacher
    {
        return new CourseComponentTeacher($this);
    }

    public function webAanvraag(): WebAanvraag
    {
        return new WebAanvraag($this);
    }

    public function persoon(): Persoon
    {
        return new Persoon($this);
    }

    public function teacher(): Teacher
    {
        return new Teacher($this);
    }
}
