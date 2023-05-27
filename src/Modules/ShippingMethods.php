<?php

namespace Sendcloud\Modules;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Sendcloud\Module;
use Sendcloud\SendcloudResponse;

class ShippingMethods extends Module
{
    /**
     * Retrieve a list of shipping methods
     * 
     * This endpoint will return a detailed list of all the shipping methods which are available 
     * to you under your Sendcloud credentials. 
     * You can use this endpoint to find a specific shipping method id, which you can then specify 
     * in your request to Create a parcel.
     * 
     * If a shipping method id value is present, and if the request_label parameter has the value true, 
     * then a shipping label is created and the parcel is announced.
     * 
     * The shipping methods returned are based on the following factors:
     *  The carriers you have enabled in your Sendcloud account;
     *  (Optional) The direct carrier contracts you have connected; and,
     *  Your sender address
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/shipping-methods/operations/list-shipping-methods
     *
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     * 
     * @throws ConnectException 
     * @throws ClientException 
     * @throws ServerException 
     */
    public function list(array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/shipping_methods';

        return $this->sendcloud->request('get', $endpoint, $query);
    }

    /**
     * Retrieve a shipping method
     * 
     * This endpoint will return information about a shipping method based on the provided 
     * shipping method id and your default sender address.
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/shipping-methods/operations/get-a-shipping-method
     *
     * @param string $methodId
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     * 
     * @throws ConnectException 
     * @throws ClientException 
     * @throws ServerException 
     */
    public function get(string $methodId, array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/shipping_methods/' . $methodId;

        return $this->sendcloud->request('get', $endpoint, $query);
    }
}
