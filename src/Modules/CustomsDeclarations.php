<?php

namespace Sendcloud\Modules;

use Sendcloud\Exceptions\ApiException;
use Sendcloud\Module;
use Sendcloud\SendcloudResponse;

class CustomsDeclarations extends Module
{
    /**
     * Retrieve a customs declaration PDF
     * 
     * Retrieve the customs documents associated with a label in PDF format for a normal printer.
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/labels/operations/get-a-customs-declaration-normal-printer
     *
     * @param string $parcelId
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     */
    public function get(string $parcelId, array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/customs_declaration/normal_printer/' . $parcelId;

        return $this->sendcloud->request('get', $endpoint, $query);
    }

    /**
     * Retrieve multiple customs declaration PDF
     * 
     * Retrieve PDF customs documents suitable for normal printers for multiple different parcels at the same time.
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/labels/operations/get-a-customs-declaration-normal-printer-1
     * 
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     */
    public function getMultiplePdf(array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/customs_declaration/normal_printer';

        if (!isset($query['ids']))
        {
            throw new ApiException('Please provide parcel ids array.');
        }

        return $this->sendcloud->request('get', $endpoint, $query);
    }
}