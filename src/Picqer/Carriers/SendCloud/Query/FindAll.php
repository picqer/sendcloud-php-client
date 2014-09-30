<?php namespace Picqer\Carriers\SendCloud\Query;

trait FindAll {

    public function all()
    {
        $result = $this->connection()->get($this->url);

        return $this->collectionFromResult($result);
    }

    public function collectionFromResult($result)
    {
        $collection = [];
        foreach ($result[$this->namespaces['plural']] as $r)
        {
            $collection[] = new self($this->connection(), $r);
        }

        return $collection;
    }

}