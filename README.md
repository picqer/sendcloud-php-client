Sendcloud PHP API Client
==========
An unofficial client for the Sendcloud API. More info about Sendcloud on https://sendcloud.nl. Below are some examples on the usage of this client.

Full docs of the Sendcloud API can be found on https://docs.sendcloud.sc/api/v2/index.html

## Installation
This project can easily be installed through Composer.

```
composer require picqer/sendcloud-php-client
```

## Set-up connection
Prepare the client for connecting to Sendcloud with your API key and API secret. (Optionally you can send your Partner id as 3rd param.)
```php
$connection = new \Picqer\Carriers\SendCloud\Connection('apikey', 'apisecret');
$sendcloudClient = new \Picqer\Carriers\SendCloud\SendCloud($connection);
```

## Get all parcels
Returns an array of Parcel objects
```php
$parcels = $sendcloudClient->parcels()->all();
```

## Get a single parcel
Returns a Parcel object
```php
$parcel = $sendcloudClient->parcels()->find(2342);
```

## Create a new parcel
```php
$parcel = $sendcloudClient->parcels();

$parcel->name = 'John Smith';
$parcel->company_name = 'ACME';
$parcel->address = 'Wellingtonstreet 25';
$parcel->city = 'Wellington';
$parcel->postal_code = '3423 DD';
$parcel->country = 'NL';
$parcel->requestShipment = true;
$parcel->shipment = 10; // Shipping method, get possibilities from $sendCloud->shippingMethods()->all()
$parcel->order_number = 'ORDER2014-52321';

$parcel->save();
```

## Getting label from parcel
```php
$labelUrl = $parcel->getPrimaryLabelUrl();

$documentDownloader = new \Picqer\Carriers\SendCloud\DocumentDownloader($connection);
$labelContents = $documentDownloader->getDocument($labelUrl, 'pdf');
```

## Exceptions
Actions to the API may cause an Exception to be thrown in case something went wrong
```php
try {
    $parcel->save();
} catch (SendCloudApiException $e) {
    throw new Exception($e->getMessage());
}
```
