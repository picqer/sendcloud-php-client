<?php namespace Picqer\Carriers\SendCloud;

class ShippingMethod extends Model {

    use Query\Findable;

    protected $fillable = [
        'id',
        'name',
        'price',
        'options',
        'combinations',
        'countries'
    ];

    protected $url = 'shipping_methods';

    protected $namespaces = [
        'singular' => 'shipping_method',
        'plural' => 'shipping_methods'
    ];

}