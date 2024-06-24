<?php

namespace Picqer\Carriers\SendCloud;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;

class Connection
{
    private string $apiUrl = 'https://panel.sendcloud.sc/api/v2/';
    private string $apiKey;
    private string $apiSecret;
    private ?string $partnerId;
    private ?int $maxResponseSizeInBytes;

    private Client $client;
    protected array $middleWares = [];

    public function __construct(string $apiKey, string $apiSecret, ?string $partnerId = null)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->partnerId = $partnerId;
        $this->maxResponseSizeInBytes = null;
    }

    public function client(): Client
    {
        if ($this->client) {
            return $this->client;
        }

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

        if (! is_null($this->partnerId)) {
            $clientConfig['headers']['Sendcloud-Partner-Id'] = $this->partnerId;
        }

        $this->client = new Client($clientConfig);

        return $this->client;
    }

    public function insertMiddleWare($middleWare): void
    {
        $this->middleWares[] = $middleWare;
    }

    public function apiUrl(): string
    {
        return $this->apiUrl;
    }

    public function get($url, $params = []): array
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

    public function post($url, $body, $query = []): array
    {
        try {
            $result = $this->client()->post($url, ['body' => $body, 'query' => $query]);
            return $this->parseResponse($result);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $this->parseResponse($e->getResponse());
            }

            throw new SendCloudApiException('SendCloud error: (no error message provided)' . $e->getResponse(), $e->getResponse()->getStatusCode());
        }
    }

    public function put($url, $body, $query = []): array
    {
        try {
            $result = $this->client()->put($url, ['body' => $body, 'query' => $query]);
            return $this->parseResponse($result);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $this->parseResponse($e->getResponse());
            }

            throw new SendCloudApiException('SendCloud error: (no error message provided)' . $e->getResponse(), $e->getResponse()->getStatusCode());
        }
    }

    public function delete($url, $query = []): array
    {
        try {
            $result = $this->client()->delete($url, ['query' => $query]);
            return $this->parseResponse($result);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $this->parseResponse($e->getResponse());
            }

            throw new SendCloudApiException('SendCloud error: (no error message provided)' . $e->getResponse(), $e->getResponse()->getStatusCode());
        }
    }

    public function parseResponse(ResponseInterface $response): array
    {
        try {
            // Rewind the response (middlewares might have read it already)
            $response->getBody()->rewind();

            $responseBody = $response->getBody()->getContents();

            if (! is_null($this->maxResponseSizeInBytes)) {
                if (strlen($responseBody) > $this->maxResponseSizeInBytes) {
                    throw new MaximumResponseSizeException(sprintf('Response size exceeded maximum of %d bytes', $this->maxResponseSizeInBytes));
                }
            }

            $resultArray = json_decode($responseBody, true);

            if (! is_array($resultArray)) {
                throw new SendCloudApiException(sprintf(
                    'SendCloud error %s: %s',
                    $response->getStatusCode(),
                    $responseBody
                ), $response->getStatusCode());
            }

            if (
                array_key_exists('error', $resultArray)
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
     * @deprecated
     */
    public function getEnvironment(): string
    {
        return 'live';
    }

    /**
     * @deprecated
     */
    public function setEnvironment($environment): void
    {
        if ($environment === 'test') {
            throw new SendCloudApiException('SendCloud test environment is no longer available');
        }
    }

    public function setMaxResponseSizeInBytes(?int $maxResponseSizeInBytes): void
    {
        $this->maxResponseSizeInBytes = $maxResponseSizeInBytes;
    }

    public function download($url, array $headers = ['Accept' => 'application/pdf']): string
    {
        try {
            $result = $this->client()->get($url, ['headers' => $headers]);
        } catch (RequestException $e) {
            throw new SendCloudApiException('SendCloud error: ' . $e->getMessage(), $e->getResponse()->getStatusCode());
        }

        return $result->getBody()->getContents();
    }
}
