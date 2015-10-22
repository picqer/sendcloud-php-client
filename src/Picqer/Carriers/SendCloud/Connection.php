<?php namespace Picqer\Carriers\SendCloud;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class Connection {

    /**
     * Holds the API url for live requests
     *
     * @var string
     */
    private $testUrl = 'http://demo.sendcloud.nl/api/v2/';

    /**
     * Holds the API url for test requests
     *
     * @var string
     */
    private $liveUrl = 'https://panel.sendcloud.nl/api/v2/';

    /**
     * The environment we work in
     *
     * @var string
     */
    private $environment = 'live';

    /**
     * The API key
     *
     * @var string
     */
    private $apiKey;

    /**
     * The API secret
     *
     * @var string
     */
    private $apiSecret;

    /**
     * Contains the HTTP client (Guzzle)
     * @var Client
     */
    private $client;

    /**
     * @param string $apiKey API key for SendCloud
     * @param string $apiSecret API secret for SendCloud
     */
    public function __construct($apiKey, $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * @return Client
     */
    public function client()
    {
        if ($this->client) return $this->client;

        $this->client = new Client([
            'base_uri' => $this->apiUrl(),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'auth' => [$this->apiKey, $this->apiSecret]
        ]);

        return $this->client;
    }

    public function setDebug($handle)
    {
    }

    /**
     * Return the correct url for set environment
     *
     * @return string
     */
    public function apiUrl()
    {
        return $this->environment == 'live' ? $this->liveUrl : $this->testUrl;
    }

    /**
     * Perform a GET request
     * @param string $url
     * @return array
     * @throws SendCloudApiException
     */
    public function get($url)
    {
        try {
            $result = $this->client()->get($url);
        } catch (RequestException $e) {
            if ($e->hasResponse())
                $this->parseResponse($e->getResponse());

            throw new SendCloudApiException('SendCloud error: (no error message provided)' . $e->getResponse());
        }

        return $this->parseResponse($result);
    }

    /**
     * Perform a POST request
     * @param string $url
     * @param mixed $body
     * @return string
     * @throws SendCloudApiException
     */
    public function post($url, $body)
    {
        try {
            $result = $this->client()->post($url, ['body' => $body]);
        } catch (RequestException $e) {
            if ($e->hasResponse())
                $this->parseResponse($e->getResponse());

            throw new SendCloudApiException('SendCloud error: (no error message provided)' . $e->getResponse());
        }

        return $this->parseResponse($result);
    }

    /**
     * Perform PUT request
     * @param string $url
     * @param mixed $body
     * @return string
     * @throws SendCloudApiException
     */
    public function put($url, $body)
    {
        try {
            $result = $this->client()->put($url, ['body' => $body]);
        } catch (RequestException $e) {
            if ($e->hasResponse())
                $this->parseResponse($e->getResponse());

            throw new SendCloudApiException('SendCloud error: (no error message provided)' . $e->getResponse());
        }

        return $this->parseResponse($result);
    }

    /**
     * Perform DELETE request
     * @param string $url
     * @return string
     * @throws SendCloudApiException
     */
    public function delete($url)
    {
        try {
            $result = $this->client()->delete($url);
        } catch (RequestException $e) {
            if ($e->hasResponse())
                $this->parseResponse($e->getResponse());

            throw new SendCloudApiException('SendCloud error: (no error message provided)' . $e->getResponse());
        }

        return $this->parseResponse($result);
    }

    /**
     * @param Response $response
     * @return array Parsed JSON result
     * @throws SendCloudApiException
     */
    public function parseResponse(Response $response)
    {
        try {
            $resultArray = json_decode($response->getBody()->getContents(), true);

            if (! is_array($resultArray)) {
                throw new SendCloudApiException(sprintf('SendCloud error %s: %s', $response->getStatusCode(), $response->getBody()->getContents()));
            }

            if (array_key_exists('error', $resultArray)
                && is_array($resultArray['error'])
                && array_key_exists('message', $resultArray['error'])
            )
            {
                throw new SendCloudApiException('SendCloud error: ' . $resultArray['error']['message']);
            }

            return $resultArray;
        } catch (\RuntimeException $e) {
            throw new SendCloudApiException('SendCloud error: ' . $e->getMessage());
        }
    }

    /**
     * Returns the selected environment
     *
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Set the environment for the client
     *
     * @param string $environment
     * @throws SendCloudApiException
     */
    public function setEnvironment($environment)
    {
        $allowedEnvironments = [
            'live',
            'test'
        ];

        if (! in_array($environment, $allowedEnvironments))
            throw new SendCloudApiException('Selected environment not in allowed environments');

        $this->environment = $environment;
    }

}

