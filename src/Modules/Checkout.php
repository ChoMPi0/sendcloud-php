<?php

namespace Sendcloud\Modules;

use Sendcloud\Module;
use Sendcloud\SendcloudResponse;

class Checkout extends Module
{
    /**
     * Retrieve a list of delivery options
     *
     * To use this API, you first need to create your own Dynamic Checkout configuration in the Sendcloud panel.
     * 
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/dynamic-checkout/operations/list-checkout-configuration-delivery-options
     *
     * @param string $configurationId
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     */
    public function get(string $configurationId, array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/checkout/configurations/' . $configurationId . '/delivery-options';

        return $this->sendcloud->request('get', $endpoint, $query);
    }
}
