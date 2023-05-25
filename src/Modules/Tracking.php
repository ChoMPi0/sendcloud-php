<?php

namespace Sendcloud\Modules;

use Sendcloud\Module;
use Sendcloud\SendcloudResponse;

class Tracking extends Module
{
    /**
     * Fetches the detailed tracking information, including the status history of the parcel
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/tracking/operations/get-a-tracking
     *
     * @param string $trackingNumber
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     */
    public function get(string $trackingNumber, array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/tracking/' . $trackingNumber;

        return $this->sendcloud->request('get', $endpoint, $query);
    }
}
