<?php

namespace Sendcloud\Modules;

use Sendcloud\Module;
use Sendcloud\SendcloudResponse;

class ParcelDocuments extends Module
{
    /**
     * Retrieve Parcel Documents
     *
     * For international shipments, a commercial invoice, CN23 or CN22 (+CP71) form must be attached 
     * (either physically or digitally for some carriers) to the shipment for customs officials to access. 
     * The type of document required depends on the shipping method and value of the shipment.
     * Sendcloud will generate the correct type of document for your shipment when you Create a parcel, 
     * provided that you have filled in all the information related to the parcel contents, value and invoice. 
     * Use this endpoint to retrieve these documents in your preferred format.
     * 
     * The supported document types are as follows:
     *  air-waybill
     *  cn23
     *  cn23-default
     *  commercial-invoice
     *  cp71
     *  label
     *  qr
     * 
     * @link https://api.sendcloud.dev/docs/sendcloud-public-api/parcel-documents/operations/get-a-parcel-document
     *
     * @param string $parcelId
     * @param string $documentType
     * @param array $query Params to pass in the query string
     *
     * @return SendcloudResponse
     */
    public function get(string $parcelId, string $documentType, array $query = []): SendcloudResponse
    {
        $endpoint = '/api/v2/parcels/' . $parcelId . '/documents/' . $documentType;

        return $this->sendcloud->request('get', $endpoint, $query);
    }
}
