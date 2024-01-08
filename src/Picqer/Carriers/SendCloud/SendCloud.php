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

    public function invoices(): Invoice
    {
        return new Invoice($this->connection);
    }

    public function labels(): Label
    {
        return new Label($this->connection);
    }

    public function parcels(): Parcel
    {
        return new Parcel($this->connection);
    }

    public function shippingMethods(): ShippingMethod
    {
        return new ShippingMethod($this->connection);
    }

    public function parcelStatuses(): ParcelStatus
    {
        return new ParcelStatus($this->connection);
    }

    public function users(): User
    {
        return new User($this->connection);
    }

    public function senderAddresses(): SenderAddress
    {
        return new SenderAddress($this->connection);
    }

    public function contracts(): Contract
    {
        return new Contract($this->connection);
    }

    /**
     * SenderAddress Resource
     *
     * @return SenderAddress
     * @deprecated Inconsistent nameing, use senderAddresses()
     */
    public function sender_addresses()
    {
        return $this->senderAddresses();
    }
}
