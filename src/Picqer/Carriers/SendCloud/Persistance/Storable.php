<?php

namespace Picqer\Carriers\SendCloud\Persistance;

use Picqer\Carriers\SendCloud\Connection;

/**
 * Trait Storable
 *
 * @method Connection connection()
 *
 * @package Picqer\Carriers\SendCloud\Persistance
 */
trait Storable
{
    public function save($options = [])
    {
        if ($this->exists()) {
            $this->fill($this->update($options));
        } else {
            $this->fill($this->insert($options));
        }

        return $this;
    }

    public function insert(array $options = [])
    {
        return $this->connection()->post($this->url, $this->json(), $options);
    }

    public function update(array $options = [])
    {
        return $this->connection()->put($this->url . '/' . urlencode($this->id), $this->json(), $options);
    }

    public function delete(array $options = [])
    {
        return $this->connection()->delete($this->url . '/' . urlencode($this->id), $options);
    }
}
