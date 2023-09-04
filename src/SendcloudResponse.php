<?php

namespace Sendcloud;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use GuzzleHttp\Psr7\MessageTrait;
use Sendcloud\Exceptions\InvalidPayloadException;
use JsonException;

class SendcloudResponse implements ResponseInterface
{
    use MessageTrait;

    /**
     * @var string 
     */
    protected $reasonPhrase;

    /** 
     * @var int
     */
    protected $statusCode;

    /**
     * An array containing the response data.
     *
     * @var array|null
     */
    protected ?array $payload;

    /**
     * An array containing the response error data.
     * 
     * @var array|null
     */
    protected ?array $error = null;

    /** Map of standard HTTP status code/reason phrases */
    protected const PHRASES = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-status',
        208 => 'Already Reported',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Requested range not satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    ];

    /**
     * @param int                                  $status  Status code
     * @param array<string, string|string[]>       $headers Response headers
     * @param StreamInterface|null                 $body    Response body
     * @param string                               $version Protocol version
     * @param string|null                          $reason  Reason phrase (when empty a default will be used based on the status code)
     */
    public function __construct(int $status = 200, array $headers = [], ?StreamInterface $body = null, string $version = '1.1', string $reason = null)
    {
        $this->statusCode = $status;
        if (!empty($headers))
        {
            $this->setHeaders($headers);
        }
        $this->stream = $body;
        $this->protocol = $version;
        if ((!$reason || $reason == '') && isset(self::PHRASES[$this->statusCode]))
        {
            $this->reasonPhrase = self::PHRASES[$this->statusCode];
        }
        else if ($reason)
        {
            $this->reasonPhrase = $reason;
        }
        else
        {
            $this->reasonPhrase = 'Unknown status code';
        }
        $this->payload = $this->interpretResponse($body, $this->statusCode);
    }

    public function interpretResponse(string $rbody, int $rcode): mixed
    {
        try
        {
            $resp = json_decode($rbody, true, 512, JSON_THROW_ON_ERROR);
        }
        catch (JsonException $e)
        {
            throw new InvalidPayloadException("Invalid response body from API, code: {$rcode}, body: {$rbody}", $e->getCode(), $e);
        }

        if (isset($resp['error']))
        {
            $this->error = $resp['error'];
            return null;
        }

        return $resp;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getError(): object
    {
        return (object)$this->error;
    }

    public function withStatus($code, $reasonPhrase = ''): ResponseInterface
    {
        $code = (int)$code;

        $new = clone $this;
        $new->statusCode = $code;
        if ($reasonPhrase == '' && isset(self::PHRASES[$new->statusCode])) {
            $reasonPhrase = self::PHRASES[$new->statusCode];
        }
        $new->reasonPhrase = (string)$reasonPhrase;
        return $new;
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
