<?php

namespace Sendcloud\Modules;

use Sendcloud\Module;
use Sendcloud\SendcloudResponse;
use Sendcloud\Exceptions\ApiException;

class Pickups extends Module
{
    /**
     * Retrieve a pickup
     * 
     * This endpoint allows you to retrieve information about a specific pickup based on the pickup id.
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/pickups/operations/get-a-pickup
     *
     * @param string $pickupId
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     */
    public function get(string $pickupId, array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/pickups/' . $pickupId;

        return $this->sendcloud->request('get', $endpoint, $query);
    }

    /**
     * Create a pickup
     *
     * This endpoint allows you to schedule a pickup with a supporting carrier. 
     * You can schedule the pickup to take place from a location and time of your choosing, 
     * and include any additional instructions to the driver by including the special_instructions parameter. 
     * When a pickup is successfully scheduled a pickup id will be returned.
     * 
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/pickups/operations/create-a-pickup
     *
     * @param array $payload
     *
     * @return SendcloudResponse
     */
    public function create(array $payload): SendcloudResponse
    {
        $endpoint = '/api/v2/pickups';

        return $this->sendcloud->request('post', $endpoint, $payload);
    }

    /**
     * Retrieve a list of pickups
     *
     * This endpoint retrieves information about all the pickups which have been created from your account. 
     * This is limited to the carriers which support pickups via the API. 
     * The response includes information about when the pickup was scheduled, 
     * the latest status, the parcel tracking number and the time frame in which the pickup is due to take place.
     * 
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/pickups/operations/list-pickups
     *
     * @return SendcloudResponse
     */
    public function list(array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/pickups';

        return $this->sendcloud->request('get', $endpoint, $query);
    }
}
