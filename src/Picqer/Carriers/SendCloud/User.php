<?php namespace Picqer\Carriers\SendCloud;

class User extends Model {

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