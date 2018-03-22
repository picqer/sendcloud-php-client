<?php

namespace Picqer\Carriers\SendCloud;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;

class Connection
{

    /**
     * Holds the API url for test requests
     *
     * @var string
     */
    private $apiUrl = 'https://panel.sendcloud.sc/api/v2/';

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
     * The Sendcloud Partner ID
     *
     * @var string
     */
    private $partnerId;

    /**
     * Contains the HTTP client (Guzzle)
     * @var Client
     */
    private $client;

    /**
     * Array of inserted middleWares
     * @var array
     */
    protected $middleWares = [];


    /**
     * @param string $apiKey API key for SendCloud
     * @param string $apiSecret API secret for SendCloud
     */
    public function __construct($apiKey, $apiSecret, $partnerId = null)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->partnerId = $partnerId;
    }

    /**
     * @return Client
     */
    public function client()
    {
        if ($this->client) return $this->client;

        $handlerStack = HandlerStack::create();
        foreach ($this->middleWares as $middleWare) {
            $handlerStack->push($middleWare);
        }

        $clientConfig = [
            'base_uri' => $this->apiUrl(),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'auth' => [$this->apiKey, $this->apiSecret],
            'handler' => $handlerStack
        ];

        if (!is_null($this->partnerId)) {
            $clientConfig['headers']['Sendcloud-Partner-Id'] = $this->partnerId;
        }

        $this->client = new Client($clientConfig);

        return $this->client;
    }

    public function insertMiddleWare($middleWare)
    {
        $this->middleWares[] = $middleWare;
    }

    /**
     * Return the correct url for set environment
     *
     * @return string
     */
    public function apiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * Return the api key
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Perform a GET request
     * @param string $url
     * @param array $params
     * @return array
     * @throws SendCloudApiException
     */
    public function get($url, $params = [])
    {
        try {
            $result = $this->client()->get($url, ['query' => $params]);
            return $this->parseResponse($result);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $this->parseResponse($e->getResponse());
            }

            throw new SendCloudApiException('SendCloud error: (no error message provided)' . $e->getResponse(), $e->getResponse()->getStatusCode());
        }
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
            return $this->parseResponse($result);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $this->parseResponse($e->getResponse());
            }

            throw new SendCloudApiException('SendCloud error: (no error message provided)' . $e->getResponse(), $e->getResponse()->getStatusCode());
        }
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
            return $this->parseResponse($result);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $this->parseResponse($e->getResponse());
            }

            throw new SendCloudApiException('SendCloud error: (no error message provided)' . $e->getResponse(), $e->getResponse()->getStatusCode());
        }
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
            return $this->parseResponse($result);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $this->parseResponse($e->getResponse());
            }

            throw new SendCloudApiException('SendCloud error: (no error message provided)' . $e->getResponse(), $e->getResponse()->getStatusCode());
        }
    }

    /**
     * @param ResponseInterface $response
     * @return array Parsed JSON result
     * @throws SendCloudApiException
     */
    public function parseResponse(ResponseInterface $response)
    {
        try {
            // Rewind the response (middlewares might have read it already)
            $response->getBody()->rewind();

            $responseBody = $response->getBody()->getContents();
            $resultArray = json_decode($responseBody, true);

            if (!is_array($resultArray)) {
                throw new SendCloudApiException(sprintf('SendCloud error %s: %s', $response->getStatusCode(), $responseBody), $response->getStatusCode());
            }

            if (array_key_exists('error', $resultArray)
                && is_array($resultArray['error'])
                && array_key_exists('message', $resultArray['error'])
            ) {
                throw new SendCloudApiException('SendCloud error: ' . $resultArray['error']['message'], $resultArray['error']['code']);
            }

            return $resultArray;
        } catch (\RuntimeException $e) {
            throw new SendCloudApiException('SendCloud error: ' . $e->getMessage());
        }
    }

    /**
     * Returns the selected environment
     *
     * @deprecated
     * @return string
     */
    public function getEnvironment()
    {
        return 'live';
    }

    /**
     * Set the environment for the client
     *
     * @deprecated
     * @param string $environment
     * @throws SendCloudApiException
     */
    public function setEnvironment($environment)
    {
        if ($environment === 'test') {
            throw new SendCloudApiException('SendCloud test environment is no longer available');
        }
    }

    /**
     * Download a resource.
     *
     * @param string $url
     * @return string
     * @throws SendCloudApiException
     */
    public function download($url)
    {
        try {
            $result = $this->client()->get($url);
        } catch (RequestException $e) {
            throw new SendCloudApiException('SendCloud error: ' . $e->getMessage(), $e->getResponse()->getStatusCode());
        }

        return $result->getBody()->getContents();
    }
}

