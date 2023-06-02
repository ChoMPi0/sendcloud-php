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
     * This endpoint allows you to retrieve a specific parcel created under your Sendcloud credentials, 
     * based on the parcel id.
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
     * This endpoint allows you to retrieve a list of all the parcels which you have created 
     * or imported into your Sendcloud account under your API credentials. 
     * You can filter the results based on the query parameters provided below, 
     * in order to retrieve a specific parcel or list of parcels which match the defined criteria.
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
     * Create a single parcel or a batch of parcels
     *
     * This endpoint creates a parcel under your API credentials.
     * You can choose to announce the parcel and create the shipping label at the same time as 
     * you create the parcel by providing the parameter request_label: "true".
     * When request_label is false, you can create the parcel but it will not be announced.
     * You can then request the shipping label at a later date by changing the request_label 
     * parameter via the Update a parcel endpoint.

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
     * This endpoint allows you to update a parcel which has not yet been announced, either to make 
     * changes to the original parcel data, or to request a shipping label if one hasn't yet been created. 
     * You'll need to include the parcel_id of the parcel you wish to update, which you can retrieve 
     * via the Get all parcels endpoint. 
     * Note that, when updating a parcel with a quantity higher than 1 (e.g. a multi-collo shipment), 
     * setting request_label=true is not allowed, since multiple parcels will be returned.
     * 
     * @param array $payload
     *
     * @return SendcloudResponse
     */
    public function update(array $payload): SendcloudResponse
    {
        $endpoint = '/api/v2/parcels';

        if (!isset($payload['parcel']) && !isset($payload['parcel']['id']))
        {
            throw new ApiException('Please provide parcel id.');
        }

        return $this->sendcloud->request('put', $endpoint, $payload);
    }

    /**
     * Delete a parcel
     *
     * You can use this endpoint to:
     * Cancel an announced parcel; or,
     * Delete an unnanounced parcel
     * 
     * Cancelling a parcel
     * When you cancel a parcel which is already announced (has a shipping label attached to it), 
     * you will still be able to find it via the parcel_id and the Retrieve a parcel endpoint. 
     * In the Sendcloud panel, it will appear in your Cancelled labels overview.
     * 
     * Deleting a parcel
     * When you delete a parcel which hasn't been announced, the parcel will be removed from the Sendcloud 
     * system and you will no longer be able to locate it via the parcel id. You will need to create the 
     * parcel again if you want to announce it at a later date.
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
     * This endpoint lets you see which of your branded Return portals is associated with a specific parcel based 
     * on the provided parcel id. The URL which is retrieved will link directly to the parcel in the 
     * Sendcloud Return portal, so a return parcel can be created immediately based on the outgoing shipment. 
     * If no Return portal is configured, or if no brand is connected to the parcel, 
     * this endpoint will return a status code 404 error.
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
