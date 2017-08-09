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

    use Query\Findable;

    protected $fillable = [
        'sender_address'
    ];

    protected $url = 'service-points';

    protected $namespaces = [
        'singular' => '',
        'plural' => ''
    ];

}
