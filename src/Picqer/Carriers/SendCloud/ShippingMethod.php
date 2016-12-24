<?php

namespace Picqer\Carriers\SendCloud;

/**
 * Class ShippingMethod
 *
 * @property integer id
 * @property string name
 * @property float price
 * @property array options
 * @property array countries
 *
 * @package Picqer\Carriers\SendCloud
 */
class ShippingMethod extends Model
{

    use Query\Findable;

    protected $fillable = [
        'id',
        'name',
        'price',
        'options',
        'countries'
    ];

    protected $url = 'shipping_methods';

    protected $namespaces = [
        'singular' => 'shipping_method',
        'plural' => 'shipping_methods'
    ];

}