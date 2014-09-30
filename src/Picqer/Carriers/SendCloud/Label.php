<?php namespace Picqer\Carriers\SendCloud;

class Label extends Model {

    use Query\FindOne;

    protected $fillable = [
        'normal_printer',
        'label_printer',
    ];

    protected $url = 'labels';

    protected $namespaces = [
        'singular' => 'label',
        'plural' => 'labels'
    ];

}