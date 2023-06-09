<?php

namespace Sendcloud;

/**
 * Use this file in case of manually importing the library into your project.
 */

use Exception;

if (!function_exists('json_decode')) {
    throw new Exception('Sendcloud needs the JSON PHP extension.');
}

require(dirname(__FILE__) . '/Exceptions/ApiException.php');
require(dirname(__FILE__) . '/Exceptions/InvalidPayloadException.php');
require(dirname(__FILE__) . '/Exceptions/InvalidSignatureException.php');

require(dirname(__FILE__) . '/Module.php');
require(dirname(__FILE__) . '/SendcloudRequest.php');
require(dirname(__FILE__) . '/SendcloudResponse.php');

require(dirname(__FILE__) . '/Webhooks/Handler.php');
require(dirname(__FILE__) . '/Webhooks/ListenerInterface.php');

require(dirname(__FILE__) . '/Modules/Checkout.php');
require(dirname(__FILE__) . '/Modules/CustomsDeclarations.php');
require(dirname(__FILE__) . '/Modules/Downloads.php');
require(dirname(__FILE__) . '/Modules/Labels.php');
require(dirname(__FILE__) . '/Modules/ParcelDocuments.php');
require(dirname(__FILE__) . '/Modules/Parcels.php');
require(dirname(__FILE__) . '/Modules/ParcelStatuses.php');
require(dirname(__FILE__) . '/Modules/Pickups.php');
require(dirname(__FILE__) . '/Modules/ShippingMethods.php');
require(dirname(__FILE__) . '/Modules/ShippingPrices.php');
require(dirname(__FILE__) . '/Modules/ShippingProducts.php');
require(dirname(__FILE__) . '/Modules/Tracking.php');
require(dirname(__FILE__) . '/Modules/TransitTimes.php');

require(dirname(__FILE__) . '/SendcloudAPI.php');