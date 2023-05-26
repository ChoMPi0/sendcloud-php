<?php

namespace Sendcloud\Modules;

use Sendcloud\Exceptions\ApiException;
use Sendcloud\Module;
use Sendcloud\SendcloudResponse;

class TransitTimes extends Module
{
    /**
     * Retrieve Carriers transit times
     *
     * This endpoint retrieves the average transit time of a parcel per selected carrier code. 
     * You can filter the results by origin and destination country, as well as by start and end dates.
     * 
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/transit-times/operations/list-insight-carrier-transit-times
     *
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     */
    public function getCarriers(array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/insights/carriers/transit-times';

        return $this->sendcloud->request('get', $endpoint, $query);
    }

    /**
     * Retrieve Shipping method transit times
     *
     * This endpoint retrieves the average transit time of a parcel per selected shipping method and carrier code. 
     * You can filter the results by origin and destination country, as well as start and end dates.
     * 
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/transit-times/operations/list-insight-shipping-method-transit-times
     *
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     */
    public function getShippingMethod(array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/insights/shipping-methods/transit-times';

        if (!isset($query['shipping_method_code']) || !is_array($query['shipping_method_code']))
        {
            throw new ApiException('Please provide shipping_method_code array.');
        }

        return $this->sendcloud->request('get', $endpoint, $query);
    }
}
