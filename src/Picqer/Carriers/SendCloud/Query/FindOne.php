<?php namespace Picqer\Carriers\SendCloud\Query;

trait FindOne {

    public function find($id)
    {
        $result = $this->connection()->get($this->url . '/' . urlencode($id));

        return new self($this->connection(), $result[$this->namespaces['singular']]);
    }

}