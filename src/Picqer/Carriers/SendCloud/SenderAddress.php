<?php

namespace Picqer\Carriers\SendCloud;

/**
 * Class SenderAddress
 *
 * @property integer id
 * @property string company_name
 * @property string contact_name
 * @property string email
 * @property string telephone
 * @property string street
 * @property string house_number
 * @property string postal_box
 * @property string postal_code
 * @property string city
 * @property string country
 *
 * @package Picqer\Carriers\SendCloud
 */
class SenderAddress extends Model
{
    use Query\Findable;

    protected $fillable = [
        'id',
        'company_name',
        'contact_name',
        'email',
        'telephone',
        'street',
        'house_number',
        'postal_box',
        'postal_code',
        'city',
        'country'
    ];

    protected $url = 'user/addresses/sender';

    protected $namespaces = [
        'singular' => 'sender_address',
        'plural' => 'sender_addresses'
    ];

}
