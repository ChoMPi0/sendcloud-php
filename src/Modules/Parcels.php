<?php

namespace Sendcloud\Modules;

use Sendcloud\Module;
use Sendcloud\SendcloudResponse;
use Sendcloud\Exceptions\ApiException;

class Parcels extends Module
{
    /**
     * Retrieve a parcel's details
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/parcels/operations/get-a-parcel
     *
     * @param string $parcelId
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     */
    public function get(string $parcelId, array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/parcels/' . $parcelId;

        return $this->sendcloud->request('get', $endpoint, $query);
    }

    /**
     * Retrieve a list of parcels
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/parcels/operations/list-parcels
     *
     * @return SendcloudResponse
     */
    public function list(array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/parcels';

        return $this->sendcloud->request('get', $endpoint, $query);
    }

    /**
     * Create a parcel
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/parcels/operations/create-a-parcel
     *
     * @param array $payload
     *
     * @return SendcloudResponse
     */
    public function create(array $payload): SendcloudResponse
    {
        $endpoint = '/api/v2/parcels';

        return $this->sendcloud->request('post', $endpoint, $payload);
    }

    /**
     * Update a parcel
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/parcels/operations/update-a-parcel
     *
     * @param array $payload
     *
     * @return SendcloudResponse
     */
    public function update(array $payload): SendcloudResponse
    {
        $endpoint = '/api/v2/parcels';

        if (!isset($payload['id']))
        {
            throw new ApiException('Please provide parcel id.');
        }

        return $this->sendcloud->request('put', $endpoint, $payload);
    }

    /**
     * Delete a parcel
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/parcels/operations/create-a-parcel-cancel
     *
     * @param string $parcelId
     *
     * @return SendcloudResponse
     */
    public function delete(string $parcelId): SendcloudResponse
    {
        $endpoint = '/v2/parcels/' . $parcelId . '/cancel';

        return $this->sendcloud->request('post', $endpoint);
    }

    /**
     * Retrieve a parcel's return portal URL
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/parcels/operations/get-a-parcel-return-portal-url
     *
     * @param string $parcelId
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     */
    public function getReturnPortalURL(string $parcelId, array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/parcels/' . $parcelId . '/return_portal_url';

        return $this->sendcloud->request('get', $endpoint, $query);
    }
}
