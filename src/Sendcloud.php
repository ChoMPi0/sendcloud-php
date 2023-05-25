<?php

namespace Sendcloud;

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

require(dirname(__FILE__) . '/Modules/Parcels.php');
require(dirname(__FILE__) . '/Modules/Checkout.php');

require(dirname(__FILE__) . '/SendcloudAPI.php');