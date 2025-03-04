<?php

namespace Picqer\Carriers\SendCloud;

/**
 * Class ShippingMethod
 *
 * @property integer $id
 * @property string $name
 * @property string $carrier
 * @property float $price
 * @property string $min_weight
 * @property string $max_weight
 * @property array $options
 * @property array $countries
 *
 * @package Picqer\Carriers\SendCloud
 */
class ShippingMethod extends Model
{
    use Query\Findable;

    protected $fillable = [
        'id',
        'name',
        'carrier',
        'price',
        'min_weight',
        'max_weight',
        'service_point_input',
        'options',
        'countries'
    ];

    protected $url = 'shipping_methods';

    protected $namespaces = [
        'singular' => 'shipping_method',
        'plural' => 'shipping_methods'
    ];

}
