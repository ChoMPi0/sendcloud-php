<?php

namespace Sendcloud\Modules;

use Sendcloud\Module;
use Psr\Http\Message\ResponseInterface;
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
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get(string $parcelId, array $query = []): ResponseInterface
    {
        $endpoint = '/api/v2/parcels/' . $parcelId;

        return $this->sendcloud->request('get', $endpoint, $query);
    }

    /**
     * Retrieve a list of parcels
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/parcels/operations/list-parcels
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function list(array $query = []): ResponseInterface
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
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function create(array $payload): ResponseInterface
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
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update(array $payload): ResponseInterface
    {
        $endpoint = '/api/v2/parcels';

        if (!isset($payload['id']))
        {
            throw new ApiException('Please provide parcel id with the request payload.');
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
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete(string $parcelId): ResponseInterface
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
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getReturnPortalURL(string $parcelId, array $query = []): ResponseInterface
    {
        $endpoint = '/api/v2/parcels/' . $parcelId . '/return_portal_url';

        return $this->sendcloud->request('get', $endpoint, $query);
    }
}
