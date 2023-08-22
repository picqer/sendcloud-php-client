<?php

namespace Picqer\Carriers\SendCloud;

/**
 * Class Parcel
 *
 * @property string name
 * @property string company_name
 * @property integer contract
 * @property string address
 * @property string address_2
 * @property string house_number
 * @property string city
 * @property string postal_code
 * @property string telephone
 * @property bool request_label
 * @property string email
 * @property array data
 * @property array country
 * @property array shipment
 * @property float weight
 * @property string order_number
 * @property integer insured_value
 * @property string total_order_value_currency
 * @property float total_order_value
 * @property integer quantity
 * @property string shipping_method_checkout_name
 * @property string to_post_number
 * @property string country_state
 * @property integer sender_address
 * @property string customs_invoice_nr
 * @property integer customs_shipment_type
 * @property string external_reference
 * @property integer to_service_point
 * @property integer total_insured_value
 * @property string shipment_uuid
 * @property array parcel_items
 * @property bool is_return
 * @property string length
 * @property string width
 * @property string height
 * @property bool request_label_async
 * @property bool apply_shipping_rules
 * @property string from_name
 * @property string from_company_name
 * @property string from_address_1
 * @property string from_address_2
 * @property string from_house_number
 * @property string from_city
 * @property string from_postal_code
 * @property string from_country
 * @property string from_telephone
 * @property string from_email
 * @property string from_vat_number
 * @property string from_eori_number
 * @property string from_inbound_vat_number
 * @property string from_inbound_eori_number
 * @property string from_ioss_number
 * @property array address_divided
 * @property string date_created
 * @property string date_updated
 * @property string date_announced
 * @property integer id
 * @property array label
 * @property array status
 * @property array documents
 * @property string tracking_number
 * @property string colli_tracking_number
 * @property string colli_uuid
 * @property string collo_nr
 * @property integer collo_count
 * @property string|null awb_tracking_number
 * @property integer|null box_number
 * @property object customs_declaration
 * @property object errors
 *
 * @package Picqer\Carriers\SendCloud
 */
class Parcel extends Model
{
    use Query\Findable;
    use Persistance\Storable;
    use Persistance\Multiple;

    protected $fillable = [
        'name',
        'company_name',
        'contract',
        'address',
        'address_2',
        'house_number',
        'city',
        'postal_code',
        'telephone',
        'request_label',
        'email',
        'data',
        'country',
        'shipment',
        'weight',
        'order_number',
        'insured_value',
        'total_order_value_currency',
        'total_order_value',
        'quantity',
        'shipping_method_checkout_name',
        'to_post_number',
        'country_state',
        'sender_address',
        'customs_invoice_nr',
        'customs_shipment_type',
        'external_reference',
        'to_service_point',
        'total_insured_value',
        'shipment_uuid',
        'parcel_items',
        'is_return',
        'length',
        'width',
        'height',
        'request_label_async',
        'apply_shipping_rules',
        'from_name',
        'from_company_name',
        'from_address_1',
        'from_address_2',
        'from_house_number',
        'from_city',
        'from_postal_code',
        'from_country',
        'from_telephone',
        'from_email',
        'from_vat_number',
        'from_eori_number',
        'from_inbound_vat_number',
        'from_inbound_eori_number',
        'from_ioss_number',
        'address_divided',
        'date_created',
        'date_updated',
        'date_announced',
        'id',
        'label',
        'status',
        'documents',
        'tracking_number',
        'colli_tracking_number',
        'colli_uuid',
        'collo_nr',
        'collo_count',
        'awb_tracking_number',
        'box_number',
        'customs_declaration',
        'errors',
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
