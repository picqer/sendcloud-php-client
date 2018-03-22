<?php

namespace Picqer\Carriers\SendCloud\Query;

use Picqer\Carriers\SendCloud\Connection;

/**
 * Trait Filter
 *
 * @method Connection connection()
 *
 * @package Picqer\Carriers\SendCloud\Persistance
 */
trait Filter
{

    public function all($params = [])
    {
        $params['access_token'] = $this->connection->getApiKey();
        $url = $this->connection->apiUrl() . '/' . $this->url;
        $result = $this->connection->get($url, $params);

        return $result;
    }

}
