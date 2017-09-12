<?php

namespace Picqer\Carriers\SendCloud;

class SendCloud
{

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

    /**
     * Invoices Resource
     *
     * @return Invoice
     */
    public function invoices()
    {
        return new Invoice($this->connection);
    }

    /**
     * Label Resource
     *
     * @return Label
     */
    public function labels()
    {
        return new Label($this->connection);
    }

    /**
     * Parcels Resource
     *
     * @return Parcel
     */
    public function parcels()
    {
        return new Parcel($this->connection);
    }

    /**
     * Shipping Method Resource
     *
     * @return ShippingMethod
     */
    public function shippingMethods()
    {
        return new ShippingMethod($this->connection);
    }

    /**
     * User Resource
     *
     * @return User
     */
    public function users()
    {
        return new User($this->connection);
    }

    /**
     * SenderAddress Resource
     *
     * @return SenderAddress
     */
    public function sender_addresses()
    {
        return new SenderAddress($this->connection);
    }
    
    /**
     * ServicePoint Resource
     *
     * @return ServicePoint
     */
    public function servicePoints()
    {
        return new ServicePoint($this->connection);
    }

}
