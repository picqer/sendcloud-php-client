<?php namespace Picqer\Carriers\SendCloud;

class Parcel extends Model {

    use Query\Findable;
    use Persistance\Storable;

    protected $fillable = [
        'id',
        'name',
        'company_name',
        'address',
        'city',
        'postal_code',
        'telephone',
        'email',
        'data',
        'country',
        'shipment',
        'requestShipment',
        'order_number',
        'tracking_number'
    ];

    protected $url = 'parcels';

    protected $namespaces = [
        'singular' => 'parcel',
        'plural' => 'parcels'
    ];
}