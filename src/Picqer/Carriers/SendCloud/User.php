<?php

namespace Picqer\Carriers\SendCloud;

/**
 * Class User
 *
 * @property string username
 * @property string company_name
 * @property string telephone
 * @property string address
 * @property string postal_code
 * @property string city
 * @property string email
 * @property string company_logo
 * @property string registered
 * @property array data
 * @property array modules
 * @property array invoices
 *
 * @package Picqer\Carriers\SendCloud
 */
class User extends Model
{
    use Query\FindOne;

    protected $fillable = [
        'username',
        'company_name',
        'telephone',
        'address',
        'postal_code',
        'city',
        'email',
        'company_logo',
        'registered',
        'data',
        'modules',
        'invoices'
    ];

    protected $url = 'user';

    protected $namespaces = [
        'singular' => 'user',
        'plural' => 'users'
    ];

}