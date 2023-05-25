<?php

namespace Sendcloud\Modules;

use Sendcloud\Module;
use Sendcloud\SendcloudResponse;

class ParcelStatuses extends Module
{
    /**
     * Retrieve a list of all possible parcel statuses.
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/parcel-statuses/operations/list-parcel-statuses
     *
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     */
    public function get(array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/parcels/statuses';

        return $this->sendcloud->request('get', $endpoint, $query);
    }
}
