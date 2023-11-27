<?php

namespace Picqer\Carriers\SendCloud;

/**
 * @property integer $id
 * @property string $message
 */
class ParcelStatus extends Model
{
    use Query\Findable;

    protected $fillable = [
        'id',
        'message'
    ];

    protected $url = 'parcels/statuses';

    protected $namespaces = [
        'singular' => 'parcel_status',
        'plural' => 'parcel_statuses'
    ];

}
