<?php

namespace Picqer\Carriers\SendCloud;

/**
 * Class ServicePoint
 *
 * @property integer id
 * @property string name
 * @property float price
 * @property array options
 * @property array countries
 *
 * @package Picqer\Carriers\SendCloud
 */
class ServicePoint extends Model
{

    use Query\Filter;

    protected $fillable = [
        'id',
        'name',
        'street',
        'house_number',
        'postal_code',
        'city',
        'latitude',
        'longitude',
        'email',
        'phone',
        'homepage',
        'carrier',
        'country',
        'formatted_opening_times',
        'open_tomorrow'
    ];

    protected $url = 'service-points';

    protected $namespaces = [
        'singular' => '',
        'plural' => ''
    ];

}
