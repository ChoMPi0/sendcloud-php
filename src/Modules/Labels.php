<?php

namespace Sendcloud\Modules;

use Sendcloud\Exceptions\ApiException;
use Sendcloud\Module;
use Sendcloud\SendcloudResponse;

class Labels extends Module
{
    /**
     * Retrieve a Label
     * 
     * Retrieve a shipping label for a specific parcel in PDF format. You can lookup the id of a parcel via the /parcels endpoint.
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/labels/operations/get-a-label
     *
     * @param string $parcelId
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     */
    public function get(string $parcelId, array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/labels/' . $parcelId;

        return $this->sendcloud->request('get', $endpoint, $query);
    }

    /**
     * Bulk PDF label printing
     * 
     * Request multiple shipping labels for an array of parcels at the same time.
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/labels/operations/create-a-label
     *
     * @param array $payload
     *
     * @return SendcloudResponse
     */
    public function getMultiple(array $payload): SendcloudResponse
    {
        $endpoint = '/api/v2/labels';

        if (!isset($payload['label']))
        {
            throw new ApiException('Please provide label array.');
        }

        return $this->sendcloud->request('post', $endpoint, $payload);
    }

    /**
     * Retrieve a PDF label
     * 
     * Retrieve a shipping label for a specific parcel in PDF format for a normal printer.
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/labels/operations/get-a-label-normal-printer
     *
     * @param string $parcelId
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     */
    public function getPdf(string $parcelId, array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/labels/normal_printer/' . $parcelId;

        return $this->sendcloud->request('get', $endpoint, $query);
    }

    /**
     * Retrieve multiple PDF labels
     * 
     * Retrieve PDF label documents suitable for normal printers for multiple different parcels at the same time.
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/labels/operations/get-a-label-normal-printer-1
     *
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     */
    public function getMultiplePdf(array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/labels/normal_printer';

        if (!isset($query['ids']))
        {
            throw new ApiException('Please provide parcel ids array.');
        }

        return $this->sendcloud->request('get', $endpoint, $query);
    }

    /**
     * Retrieve a PDF label for a specific label printer
     * 
     * Retrieve a shipping label for a specific parcel in PDF format for a label printer.
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/labels/operations/get-a-label-label-printer
     *
     * @param string $parcelId
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     */
    public function getPdfSpecific(string $parcelId, array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/labels/label_printer/' . $parcelId;

        return $this->sendcloud->request('get', $endpoint, $query);
    }

    /**
     * Retrieve multiple PDF labels for a specific label printer
     * 
     * Retrieve PDF label documents suitable for label printers for multiple different parcels at the same time.
     *
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/labels/operations/get-a-label-label-printer-1
     *
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     */
    public function getMultiplePdfSpecific(array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/labels/label_printer';

        if (!isset($query['ids']))
        {
            throw new ApiException('Please provide parcel ids array.');
        }
        
        return $this->sendcloud->request('get', $endpoint, $query);
    }
}
