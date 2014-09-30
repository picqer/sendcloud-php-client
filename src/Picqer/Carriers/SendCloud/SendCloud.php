<?php namespace Picqer\Carriers\SendCloud;

class SendCloud {

    /**
     * The HTTP connection
     *
     * @var Connection
     */
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function invoices()
    {
        return new Invoice($this->connection);
    }

    public function labels()
    {
        return new Label($this->connection);
    }

    public function parcels()
    {
        return new Parcel($this->connection);
    }

    public function shippingMethods()
    {
        return new ShippingMethod($this->connection);
    }

    public function users()
    {
        return new User($this->connection);
    }

}