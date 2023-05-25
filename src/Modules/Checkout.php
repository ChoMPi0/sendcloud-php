<?php

namespace Sendcloud\Modules;

use Sendcloud\Module;
use Psr\Http\Message\ResponseInterface;

class Checkout extends Module
{
    /**
     * Retrieve a list of delivery options
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/dynamic-checkout/operations/list-checkout-configuration-delivery-options
     *
     * @param string $configurationId
     * @param array $query Params to pass in the query string
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get(string $configurationId, array $query = []): ResponseInterface
    {
        $endpoint = '/api/v2/checkout/configurations/' . $configurationId . '/delivery-options';

        return $this->sendcloud->request('get', $endpoint, $query);
    }
}
