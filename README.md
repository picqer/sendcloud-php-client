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

$parcel->shipment = 10; // Shipping method, get possibilities from $sendCloud->shippingMethods()->all()

$parcel->name = 'John Smith';
$parcel->company_name = 'ACME';
$parcel->address = 'Wellingtonstreet 25';
$parcel->city = 'Wellington';
$parcel->postal_code = '3423 DD';
$parcel->country = 'NL';
$parcel->order_number = 'ORDER2014-52321';

$parcel->request_label = true; // Specifically needed to create a shipment after adding the parcel

$parcel->save();
```

## Create a new parcel with a defined sender address
```php
$parcel = $sendcloudClient->parcels();

$parcel->shipment = 10; // Shipping method, get possibilities from $sendCloud->shippingMethods()->all()

$parcel->name = 'John Smith';
$parcel->company_name = 'ACME';
$parcel->address = 'Wellingtonstreet 25';
$parcel->city = 'Wellington';
$parcel->postal_code = '3423 DD';
$parcel->country = 'NL';
$parcel->order_number = 'ORDER2014-52321';

$parcel->from_name = 'John Smith';
$parcel->from_company_name = 'ACME';
$parcel->from_address = 'Wellingtonstreet 25';
$parcel->from_city = 'Wellington';
$parcel->from_postal_code = '3423 DD';
$parcel->from_country = 'NL';

$parcel->request_label = true; // Specifically needed to create a shipment after adding the parcel

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

## Create an international parcel
```php
$parcel = $sendcloudClient->parcels();

$parcel->shipment = 9; // Shipping method, get possibilities from $sendCloud->shippingMethods()->all()

$parcel->name = 'John Smith';
$parcel->company_name = 'ACME';
$parcel->address = 'Wellingtonstreet 25';
$parcel->city = 'Wellington';
$parcel->postal_code = '3423 DD';
$parcel->country = 'CH';
$parcel->order_number = 'ORDER2014-52321';
$parcel->weight = 20.4;

// For international shipments
$parcel->customs_invoice_nr = 'ORD9923882';
$parcel->customs_shipment_type = 2; // Commercial goods
$parcel->parcel_items = [
    [
        'description' => 'Cork',
        'quantity' => 2,
        'weight' => 10.2,
        'value' => 12.93,
        'hs_code' => '992783',
        'origin_country' => 'CN',
    ]
];

$parcel->request_label = true; // Specifically needed to create a shipment after adding the parcel

$parcel->save();
```
