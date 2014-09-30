<?php namespace Picqer\Carriers\SendCloud;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Message\Response;

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
            'base_url' => $this->apiUrl()
        ]);
        $this->client->setDefaultOption('headers/Accept', 'application/json');
        $this->client->setDefaultOption('headers/Content-Type', 'application/json');
        $this->client->setDefaultOption('auth', [
            $this->apiKey,
            $this->apiSecret
        ]);

        return $this->client;
    }

    public function setDebug($handle)
    {
        $this->client()->setDefaultOption('debug', $handle);
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
     * @param array $params
     * @return string
     * @throws SendCloudApiException
     */
    public function get($url, array $params = [])
    {
        $request = $this->client()->createRequest('GET', $url);

        $query = $request->getQuery();

        foreach ($params as $paramName => $paramValue)
        {
            $query->set($paramName, $paramValue);
        }

        try {
            $result = $this->client()->send($request);
        } catch (RequestException $e) {
            if ($e->hasResponse())
                throw new SendCloudApiException($e->getResponse()->getStatusCode() .': ' . $e->getResponse()->json());
        }

        return $this->parseResult($result);
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
                throw new SendCloudApiException($e->getResponse()->getStatusCode() .': ' . $e->getResponse()->json());
        }

        return $this->parseResult($result);
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
                throw new SendCloudApiException($e->getResponse()->getStatusCode() .': ' . $e->getResponse()->json());
        }

        return $this->parseResult($result);
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
                throw new SendCloudApiException($e->getResponse()->getStatusCode() .': ' . $e->getResponse()->json());
        }

        return $this->parseResult($result);
    }

    /**
     * @param Response $response
     * @return string Parsed JSON result
     * @throws SendCloudApiException
     */
    public function parseResult(Response $response)
    {
        try
        {
            $json = $response->json();
        } catch (\RuntimeException $e)
        {
            throw new SendCloudApiException($e->getMessage());
        }

        return $json;
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

