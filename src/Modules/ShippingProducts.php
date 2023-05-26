<?php

namespace Sendcloud\Modules;

use Sendcloud\Module;
use Sendcloud\SendcloudResponse;

class ShippingProducts extends Module
{
    /**
     * Retrieve a list of shipping products
     * 
     * This endpoint allows you to retrieve a list of shipping methods that are associated with your default 
     * sender address, filtered by specific criteria such as parcel dimensions, weight classes, 
     * from and to country and shipping functionality.
     * 
     * In situations where you need to find a method which supports a specific means of delivery, 
     * type of parcel or delivery deadline, for example, this endpoint allows you to filter all available 
     * shipping methods based on one or more query parameters.
     * 
     * The response body will include the id of any suitable methods, which you can then use to Create a parcel 
     * and announce the shipment directly.
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/shipping-products/operations/list-shipping-products
     *
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     */
    public function list(array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/shipping-products';

        return $this->sendcloud->request('get', $endpoint, $query);
    }
}
