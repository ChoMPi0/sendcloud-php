<?php

namespace Sendcloud\Modules;

use GuzzleHttp\Psr7\Response;
use Sendcloud\Module;

class Downloads extends Module
{
    /**
     * Download a resource from the provided URL
     * 
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/create-a-parcel#step-4-download-the-shipping-label
     *
     * @param string $url
     * @param array $query Params to pass in the query string
     *
     * @return Response
     */
    public function get(string $url, array $query = []): Response
    {
        return $this->sendcloud->requestFile('get', $url, $query);
    }
}