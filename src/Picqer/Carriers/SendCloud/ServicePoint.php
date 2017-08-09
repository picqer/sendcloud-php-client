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
        'country',
        'ne_latitude',
        'ne_longitude',
        'sw_latitude',
        'sw_longitude',
    ];

    protected $url = 'service-points';

    protected $namespaces = [
        'singular' => '',
        'plural' => ''
    ];

    public function get($params = []) {

        $url = $this->connection->apiUrl().DS.$this->url;
        $result = $this->connection->get($url, $params, 'access_token');

        return $result;
    }

}
