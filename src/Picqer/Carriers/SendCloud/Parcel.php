<?php

namespace Picqer\Carriers\SendCloud;

/**
 * Class Parcel
 *
 * @property integer $id
 * @property string $name
 * @property string $company_name
 * @property string $address
 * @property string $address_2
 * @property string $house_number
 * @property array $address_divided
 * @property string $city
 * @property string $postal_code
 * @property string $telephone
 * @property string $email
 * @property array $status
 * @property array $data
 * @property array $country
 * @property string $country_state
 * @property array $shipment
 * @property array $label
 * @property bool $requestShipment
 * @property string $order_number
 * @property string $tracking_number
 * @property float $total_order_value
 * @property string $total_order_value_currency
 * @property string $weight
 * @property string $height
 * @property string $width
 * @property string $length
 * @property string $sender_address
 * @property integer $quantity
 *
 * @package Picqer\Carriers\SendCloud
 */
class Parcel extends Model
{
    use Query\Findable;
    use Persistance\Storable;
    use Persistance\Multiple;

    protected $fillable = [
        'id',
        'address',
        'address_2',
        'house_number',
        'address_divided',
        'city',
        'company_name',
        'country',
        'country_state',
        'data',
        'date_created',
        'email',
        'name',
        'postal_code',
        'reference',
        'shipment',
        'status',
        'to_service_point',
        'telephone',
        'tracking_number',
        'weight',
        'height',
        'width',
        'length',
        'label',
        'customs_declaration',
        'order_number',
        'insured_value',
        'total_insured_value',
        'total_order_value',
        'total_order_value_currency',
        'to_state',
        'customs_invoice_nr',
        'customs_shipment_type',
        'parcel_items',
        'documents',
        'type',
        'sender_address',
        'shipment_uuid',
        'shipping_method',
        'external_order_id',
        'external_shipment_id',
        'external_reference',
        'is_return',
        'note',
        'to_post_number',
        'total_order_cost',
        'currency',
        'carrier',
        'tracking_url',
        'request_label',
        'request_label_async',
        'apply_shipping_rules',
        'shipping_method_checkout_name',
        'requestShipment', // Special one to create new shipments
        'quantity',
        'contract',
    ];

    protected $url = 'parcels';

    protected $namespaces = [
        'singular' => 'parcel',
        'plural' => 'parcels'
    ];

    public function getTrackingUrl(): ?string
    {
        return $this->tracking_url;
    }

    public function getShipperName(): ?string
    {
        return $this->carrier['code'];
    }

    public function getPrimaryLabelUrl(): string
    {
        // If multiple documents are supplied, type 'label' is the primary label
        if (is_array($this->documents)) {
            foreach ($this->documents as $document) {
                if ($document['type'] === 'label') {
                    return $document['link'];
                }
            }
        }

        // If new type of documents is not declared, use old url
        return $this->label['label_printer'];
    }
}
