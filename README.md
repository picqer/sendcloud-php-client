SendCloud PHP API Client
==========
```
$connection = new \Picqer\Carriers\SendCloud\Connection('apikey', 'apisecret');
$sendCloud = new \Picqer\Carriers\SendCloud\SendCloud($connection);

$parcels = $sendCloud->parcels()->all();

$parcel = $sendCloud->parcels()->find(2342);
```
