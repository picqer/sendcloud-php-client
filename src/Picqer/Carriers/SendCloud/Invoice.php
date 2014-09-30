<?php namespace Picqer\Carriers\SendCloud;

class Invoice extends Model {

    use Query\FindAll;

    protected $fillable = [
        'id',
        'description',
        'price_excl',
        'price_incl',
        'data',
        'isPayed',
        'items'
    ];

    protected $url = 'invoices';

    protected $namespaces = [
        'singular' => 'invoice',
        'plural' => 'invoices'
    ];

}