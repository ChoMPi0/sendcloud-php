<?php

namespace Sendcloud;

use Sendcloud\Exceptions\InvalidPayloadException;
use JsonException;

class SendcloudResponse
{
    protected $statusCode;

    /**
     * An array containing the response data.
     *
     * @var array
     */
    protected $payload;

    /**
     * @param array $payload
     */
    public function __construct(string $rbody, int $rcode)
    {
        $this->statusCode = $rcode;
        $this->payload = self::interpretResponse($rbody, $rcode);
    }

    public static function interpretResponse(string $rbody, int $rcode)
    {
        try {
            $resp = json_decode($rbody, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new InvalidPayloadException("Invalid response body from API: $rbody " . "(HTTP response code was $rcode)");
        }

        return $resp;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Magic method to allow retrieval of protected and private class properties
     * either by their name, or through a `getCamelCasedProperty()` method.
     *
     * Examples:
     *  $p = $this->my_property
     *  $p = $this->getMyProperty()
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function __get(string $key)
    {
        $result = null;

        // Convert to CamelCase for the method
        $method = 'get' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $key)));

        // if a get* method exists for this key,
        // use that method to insert this value.
        if (method_exists($this, $method)) {
            $result = $this->{$method}();
        }

        // Otherwise return the protected property
        // if it exists.
        elseif (array_key_exists($key, $this->payload)) {
            $result = $this->payload[$key];
        }

        return $result;
    }

    /**
     * Returns true if a property exists names $key, or a getter method
     * exists named like for __get().
     */
    public function __isset(string $key): bool
    {
        $method = 'get' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $key)));

        if (method_exists($this, $method)) {
            return true;
        }

        return isset($this->payload[$key]);
    }
}
