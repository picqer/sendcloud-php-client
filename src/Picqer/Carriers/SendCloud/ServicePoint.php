<?php

namespace Picqer\Carriers\SendCloud;

/**
 * Class ServicePoint
 *
 * @property integer id
 * @property string name
 * @property string street
 * @property string house_number
 * @property string postal_code
 * @property string city
 * @property string latitude
 * @property string longitude
 * @property string email
 * @property string phone
 * @property string homepage
 * @property string carrier
 * @property string country
 * @property array formatted_opening_times
 * @property boolean open_tomorrow
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
