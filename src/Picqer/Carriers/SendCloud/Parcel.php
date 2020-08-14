<?php

namespace Picqer\Carriers\SendCloud;

/**
 * Class Parcel
 *
 * @property integer id
 * @property string name
 * @property string company_name
 * @property string address
 * @property array address_divided
 * @property string city
 * @property string postal_code
 * @property string telephone
 * @property string email
 * @property array status
 * @property array data
 * @property array country
 * @property array shipment
 * @property array label
 * @property bool requestShipment
 * @property string order_number
 * @property string tracking_number
 * @property string weight
 * @property string sender_address
 *
 * @package Picqer\Carriers\SendCloud
 */
class Parcel extends Model
{
    use Query\Findable;
    use Persistance\Storable;

    protected $fillable = [
        'id',
        'address',
        'address_2',
        'address_divided',
        'city',
        'company_name',
        'country',
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
        'label',
        'customs_declaration',
        'order_number',
        'insured_value',
        'total_insured_value',
        'to_state',
        'customs_invoice_nr',
        'customs_shipment_type',
        'parcel_items',
        'documents',
        'type',
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
        // If new type of documents is not declared, use old url
        if (! is_array($this->documents) || count($this->documents) === 0) {
            return $this->label['label_printer'];
        }

        // If multiple documents are supplied, type 'label' is the primary label
        foreach ($this->documents as $document) {
            if ($document['type'] === 'label') {
                return $document['link'];
            }
        }
    }
}
