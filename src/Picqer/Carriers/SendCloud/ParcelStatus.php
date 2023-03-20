<?php

namespace Picqer\Carriers\SendCloud;

class ParcelStatus  extends Model
{
    use Query\Findable;

    protected $fillable = [
        'id',
        'message'
    ];

    protected $url = 'parcels/statuses';

    protected $namespaces = [
        'singular' => 'status',
        'plural' => 'statuses'
    ];
}
