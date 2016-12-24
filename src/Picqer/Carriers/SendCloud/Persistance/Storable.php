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
    public function save()
    {
        if ($this->exists()) {
            $this->fill($this->update());
        } else {
            $this->fill($this->insert());
        }

        return $this;
    }

    public function insert()
    {
        return $this->connection()->post($this->url, $this->json());
    }

    public function update()
    {
        return $this->connection()->put($this->url . '/' . urlencode($this->id), $this->json());
    }

    public function delete()
    {
        return $this->connection()->delete($this->url . '/' . urlencode($this->id));
    }
}