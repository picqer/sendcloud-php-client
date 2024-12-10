<?php

namespace Picqer\Carriers\SendCloud\Query;

use Picqer\Carriers\SendCloud\Connection;

/**
 * Trait FindAll
 *
 * @method Connection connection()
 *
 * @package Picqer\Carriers\SendCloud\Persistance
 */
trait FindAll
{
    public function all($params = [], ?int $maxPages = 1): array
    {
        $allRecords = [];
        $pages = 0;

        while (true) {
            $result = $this->connection()->get($this->url, $params);

            $allRecords = array_merge($allRecords, $this->collectionFromResult($result));

            if (! empty($result['next'])) {
                // Get the querystring params from the next url, so we can retrieve the next page
                $params = parse_url($result['next'], PHP_URL_QUERY);
            } else {
                // If no next page is found, all records are complete
                break;
            }

            $pages++;

            // If max pages is set and reached, also stop the loop
            if (! is_null($maxPages) && $pages >= $maxPages) {
                break;
            }
        }

        return $allRecords;
    }

    public function collectionFromResult($result): array
    {
        $collection = [];

        $resultsContainer = $result;
        if (isset($result[$this->namespaces['plural']])) {
            $resultsContainer = $result[$this->namespaces['plural']];
        }

        foreach ($resultsContainer as $item) {
            $collection[] = new self($this->connection(), $item);
        }

        return $collection;
    }
}
