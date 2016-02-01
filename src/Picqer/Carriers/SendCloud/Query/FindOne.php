<?php namespace Picqer\Carriers\SendCloud\Query;

trait FindOne {

    public function find($id)
    {
        $result = $this->connection()->get($this->url . '/' . urlencode($id));

        if (!array_key_exists($this->namespaces['singular'], $result)) {
            return null;
        }

        return new self($this->connection(), $result[$this->namespaces['singular']]);
    }

}
