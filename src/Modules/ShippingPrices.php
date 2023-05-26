<?php

namespace Sendcloud\Modules;

use Sendcloud\Module;
use Sendcloud\SendcloudResponse;

class ShippingPrices extends Module
{
    /**
     * Retrieve a shipping price
     * 
     * This endpoint retrieves shipping rate information for a specific shipping_method_id and from_country.
     * 
     * For Beta users that have uploaded their own prices, the response will show the prices that have been uploaded. 
     * The response is an Array of prices for all available receiver countries. If to_country query parameter is present, 
     * the Array will only contain one item.
     * 
     * price and currency will be null when no pricing is available for a receiver country.
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/shipping-prices/operations/get-a-shipping-price
     *
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     */
    public function get(array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/shipping-price';

        return $this->sendcloud->request('get', $endpoint, $query);
    }
}
