# sendcloud-php

A PHP library to make PHP calls to the [Sendcloud](https://www.sendcloud.com)
API. This library wraps some of the repetitive/ugly work like creating
an HTTP client, building and sending requests. The end user will just need to
assemble arrays of the appropriate payload data and then evaluate the
responses.

This package comprises two distinct sets of functionality. The first is the
API communication component, which allows the user to easily write code for
sending outbound API calls to the Sendcloud API. The second is support for
receiving inbound webhook posts from Sendcloud, allowing the user to easily
pass those calls into a dispatching handler and have their payloads passed
off to custom code attached to the handler using listeners. Webhooks are an
optional feature of Sendcloud's API and there's you can completely ignore them
if it's not part of your implementation plan.

#### API Version

* [Installation](#installation)
* [Usage](#usage)
* [Webhooks](#webhooks)
* [Roadmap](#roadmap)
* [Support](#support)
* [License](#license)

## Installation

Install with [composer](https://getcomposer.org) like normal:

```sh
composer require ChoMPi0/sendcloud-php
```

# Usage

```php
// Create the SendcloudAPI object
$publicKey = getenv('SENDCLOUD_PUBLIC_KEY');
$privateKey = getenv('SENDCLOUD_PRIVATE_KEY');
$api = new Sendcloud\SendcloudAPI($publicKey, $privateKey);

// Get a list of categories
$response = $api->categories()->list();

// Get a shipment
$response = $api->shipments()->get('ESTEST10001');

// Buy a label for a shipment
$response = $api->labels()->buy(['Sendcloud_shipment_id' => 'ESTEST10001']);
```

All methods return an instance of an object implementing
`Psr\Http\Message\ResponseInterface`, typically `GuzzleHttp\Psr7\Response`,
which can be used as needed [see the Guzzle documentation for more](https://docs.guzzlephp.org/en/stable/quickstart.html#using-responses).

By default, all of the calls are made using the request option
`'http_errors' => true`, which means that exceptions will be thrown if any
requests fail. The `SendcloudAPI::request()` method docblock shows which
exceptions you can expect to be thrown. The library allows all exceptions to
bubble up to the application so that the developer can choose how to handle
them at implementation. You can override this option in the options array
passed into the `SendcloudAPI` constructor, if you prefer.

```php
/**
 * @throws \GuzzleHttp\Exception\ConnectException on network error
 * @throws \GuzzleHttp\Exception\ClientException on 400-level errors
 * @throws \GuzzleHttp\Exception\ServerException on 500-level errors
 */
```
Of course, if you're using another PSR7-compatible client, then you'll
presumably get some exception based on `\RuntimeException`. Using other
clients isn't fully tested but in theory should work.

#### Providing Request Options to the HTTP client

The `SendcloudAPI` constructor accepts an array of request options that will
be merged into the options that are passed to the HTTP client when requests
are sent to the API endpoints. See the
[guzzle request options](https://docs.guzzlephp.org/en/stable/request-options.html) documentation for possibilities.

```php
// Pass custom options that will be used by the client
$api = new Sendcloud\SendcloudAPI($token, [
    'verify' => false, // don't verify ssl certificate
    'connect_timeout' => 30, // wait maximum 30 seconds before giving up
]);
```

#### Overriding the API host

For testing/development you may want to override the target host so that the
calls you submit will be sent to your own server for inspection.

```php
// Force all the calls from this API object to a localhost server
$api->setApiHost('http://localhost:8080/');
```

## Webhooks

See [WEBHOOKS.md](WEBHOOKS.md).

## Roadmap

* Support for API `v2` once it is ready for production use.

## Support

If you're getting unexpected results from your API calls, the most likely
case is that your payload is not valid and you'll want to consult the
[Sendcloud docs](https://api.sendcloud.dev/).
Note that you can plug values into the forms on that page, including your
sandbox token, and run the tests from the interface. If you find an issue
where the exact same call is working in Sendcloud's test page but failing
with this library, please raise an issue with a very detailed explanation
of the problem and include a copy of the exact code being run (at least
the payload of test data being passed in) so that the issue can be easily
reproduced. Please also include a copy of the incorrect response you're
getting back.

## License

This software was written by me, [Nedyalko Chakandrakov](https://www.linkedin.com/in/nedyalko-chakandrakov-31a6921a6/),
and is released under the [MIT license](LICENSE.md).
