<?php

namespace Picqer\Carriers\SendCloud;

abstract class Model
{

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var array The model's attributes
     */
    protected $attributes = [];

    /**
     * @var array The model's fillable attributes
     */
    protected $fillable = [];

    /**
     * @var string The URL endpoint of this model
     */
    protected $url = '';

    /**
     * @var string Name of the primary key for this model
     */
    protected $primaryKey = 'id';

    /**
     * @var array Defines the single and plural names for this model as used in API
     */
    protected $namespaces = [
        'singular' => '',
        'plural' => ''
    ];

    public function __construct(Connection $connection, array $attributes = [])
    {
        $this->connection = $connection;
        $this->fill($attributes);
    }

    /**
     * Get the connection instance
     *
     * @return Connection
     */
    public function connection()
    {
        return $this->connection;
    }

    /**
     * Get the model's attributes
     *
     * @return array
     */
    public function attributes()
    {
        return $this->attributes;
    }

    /**
     * Fill the entity from an array
     *
     * @param array $attributes
     */
    protected function fill(array $attributes)
    {
        if (array_key_exists($this->namespaces['singular'], $attributes))
            $attributes = $attributes[$this->namespaces['singular']];

        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            }
        }
    }

    /**
     * Get the fillable attributes of an array
     *
     * @param array $attributes
     * @return array
     */
    protected function fillableFromArray(array $attributes)
    {
        if (count($this->fillable) > 0) {
            return array_intersect_key($attributes, array_flip($this->fillable));
        }

        return $attributes;
    }

    protected function isFillable($key)
    {
        return in_array($key, $this->fillable);
    }

    protected function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function __get($key)
    {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }

        return null;
    }

    public function __isset($key)
    {
        return isset($this->attributes[$key]);
    }

    public function __set($key, $value)
    {
        if ($this->isFillable($key)) {
            $this->setAttribute($key, $value);
        }
    }

    public function exists()
    {
        if ( ! in_array($this->primaryKey, $this->attributes)) return false;

        return ! empty($this->attributes[$this->primaryKey]);
    }

    public function json()
    {
        $json = [];
        $json[$this->namespaces['singular']] = $this->attributes;
        return json_encode($json);
    }

    /**
     * Make var_dump and print_r look pretty
     *
     * @return array
     */
    public function __debugInfo()
    {
        $result = [];
        foreach ($this->fillable as $attribute) {
            $result[$attribute] = $this->$attribute;
        }
        return $result;
    }
}