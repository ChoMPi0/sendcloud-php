<?php

namespace Sendcloud;

use Sendcloud\Exceptions\ApiException;
use Sendcloud\Modules\Parcels;
use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class SendcloudAPI
{
    /**
     * @var string
     */
    protected $authToken;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var string
     */
    protected $apiHost = 'https://panel.sendcloud.sc';

    /**
     * @var \Psr\Http\Client\ClientInterface
     */
    protected $client;

    /**
     * @var \Sendcloud\SendcloudRequest
     */
    protected $lastRequest;

    /**
     * @link https://docs.guzzlephp.org/en/stable/request-options.html
     *
     * @param string $username
     * @param string $password
     * @param array $options An array of request options to be merged in
     */
    public function __construct(string $username = null, string $password = null, array $options = [])
    {
        $this->setAuthCredentials($username, $password);
        $this->options = $options;
    }

    /**
     * Send a request to the Sendcloud API and return a ResponseInterface
     * object. If the request is a GET request, any payload data will be
     * built into a query string, otherwise it will be sent as JSON content.
     *
     * @param string $method The HTTP method to be used
     * @param string $endpoint Full path to request excluding the host
     * @param array $payload An array of params
     *
     * @return \Sendcloud\SendcloudResponse
     *
     * @throws \GuzzleHttp\Exception\ConnectException on network error
     * @throws \GuzzleHttp\Exception\ClientException on 400-level errors
     * @throws \GuzzleHttp\Exception\ServerException on 500-level errors
     */
    public function request(
        string $method,
        string $endpoint,
        array $payload = []
    ): SendcloudResponse {
        $uri = $this->buildUri($this->apiHost, $endpoint);
        $request = $this->buildRequest($method, $uri, $payload);
        $this->lastRequest = $request;
        $responseRaw = $this->submitRequest($request);
        $response = new SendcloudResponse($responseRaw->getBody()->getContents(), $responseRaw->getStatusCode());

        if (!empty($response->messages))
        {
            throw new ApiException(implode(', ', $response->messages));
        }

        return $response;
    }

    public function buildRequest(
        string $method,
        string $uri,
        array $options = []
    ): SendcloudRequest {
        return new SendcloudRequest($method, $uri, $options);
    }

    /**
     * Pass a request into the Guzzle client.
     *
     * @param SendcloudRequest $request
     * @return \GuzzleHttp\Psr7\Response
     */
    public function submitRequest(SendcloudRequest $request): ResponseInterface
    {
        $uri = $request->getUri();
        $options = array_merge(
            [
                'headers' => [
                    'Authorization' => "Basic {$this->authToken}",
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'http_errors' => true,
            ],
            $this->options
        );
        
        if ($request->getPayload()) {
            if (strtolower($request->getMethod()) == 'get') {
                $uri .= '?' . http_build_query($request->getPayload());
            } else {
                $options['json'] = $request->getPayload();
            }
        }

        return $this->getClient()->request(
            $request->getMethod(),
            $uri,
            $options
        );
    }

    /**
     * Join the host and path to make a full URI for the API request,
     * ensuring there is one (and only one) slash joining them.
     *
     * @param string $host
     * @param string $path
     *
     * @return string
     */
    public function buildUri(string $host, string $path): string
    {
        return sprintf(
            '%s/%s',
            rtrim($host, '/'),
            ltrim($path, '/')
        );
    }

    /**
     * Override the default Sendcloud API host for development/testing.
     *
     * @param string $apiHost
     *
     * @return void
     */
    public function setApiHost(string $apiHost): void
    {
        $this->apiHost = $apiHost;
    }

    /**
     * Update the authentication credentials used by this object.
     *
     * @param string $username
     * @param string $password
     * @return void
     */
    public function setAuthCredentials(string $username, string $password): void
    {
        $this->authToken = base64_encode("{$username}:{$password}");
    }

    /**
     * Get an Http client to send API requests with. If none is already
     * available, an instance of GuzzleHttp/Client will be created.
     *
     * @return \Psr\Http\Client\ClientInterface
     */
    public function getClient(): ClientInterface
    {
        if (!$this->client) {
            $this->client = new Client();
        }

        return $this->client;
    }

    /**
     * Pass in a compatible HTTP client object to be used.
     *
     * @param \Psr\Http\Client\ClientInterface $client
     *
     * @return void
     */
    public function setClient(ClientInterface $client): void
    {
        $this->client = $client;
    }

    /**
     * Return the last request that was sent.
     *
     * @return \Sendcloud\SendcloudRequest
     */
    public function getLastRequest(): SendcloudRequest
    {
        return $this->lastRequest;
    }

    /**
     * @return \Sendcloud\Modules\Parcels
     */
    public function parcels(): Parcels
    {
        return new Parcels($this);
    }
}
