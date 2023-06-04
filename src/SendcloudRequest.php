<?php

namespace Sendcloud;

class SendcloudRequest
{
    /**
     * The HTTP method as it will be passed into a Guzzle client
     *
     * @var string
     */
    protected $method;

    /**
     * The complete URI for the request to be made
     *
     * @var string
     */
    protected $uri;

    /**
     * An array of data to be sent with the request.
     *
     * @var array
     */
    protected $payload;

    /**
     * An array of headers to be sent with the request.
     * 
     * @var array
     */
    protected $headers;

    /**
     * @param string $method
     * @param string $uri
     * @param array $payload
     * @param array $headers An array of additional headers
     */
    public function __construct(string $method, string $uri, array $payload, array $headers = [])
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->payload = $payload;
        $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * @return array 
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
