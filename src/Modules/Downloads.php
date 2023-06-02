<?php

namespace Sendcloud\Modules;

use Sendcloud\Module;
use Sendcloud\SendcloudResponse;

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
     * @return SendcloudResponse
     */
    public function get(string $url, array $query = []): SendcloudResponse
    {
        return $this->sendcloud->request('get', $url, $query);
    }
}