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
        'name',
        'company_name',
        'address',
        'house_number',
        'address_divided',
        'address_2',
        'city',
        'postal_code',
        'telephone',
        'email',
        'status',
        'data',
        'country',
        'shipment',
        'label',
        'reference',
        'requestShipment',
        'request_label',
        'request_label_async',
        'order_number',
        'tracking_number',
        'weight',
        'to_service_point',
        'total_insured_value',
        'sender_address'
    ];

    protected $url = 'parcels';

    protected $namespaces = [
        'singular' => 'parcel',
        'plural' => 'parcels'
    ];

    protected $shipperShippingMethodIds = [
        'BPost' => [54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 82, 83, 95, 96],
        'DHL' => [9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 38, 40, 53, 81, 117],
        'DHL Germany' => [89, 90, 91, 92, 93, 94],
        'DPD' => [41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 85, 86, 87, 109],
        'Fadello' => [88],
        'PostNL' => [1, 2, 3, 4, 5, 6, 7, 29, 30, 31, 32, 33, 34, 35, 36, 37, 39, 84, 318, 319, 320, 321, 322, 323, 324, 325, 326],
    ];

    public function getTrackingUrl()
    {
        // SendCloud now gives us this undocumented field, so if it exists use this
        if ( ! empty($this->tracking_url)) {
            return $this->tracking_url;
        }

        // Otherwise build url based on old method
        $shipper = $this->getShipperName();

        switch ($shipper) {
            case 'BPost':
                return sprintf('http://track.bpost.be/btr/web/#/search?itemCode=%s&lang=en', $this->tracking_number);
                break;
            case 'DHL':
                return sprintf('https://www.dhlparcel.%s/%s/particulier/ontvangen/track-trace?tt=%s', $this->country['iso_2'] == 'BE' ? 'be' : 'nl', 'nl', $this->tracking_number);
                break;
            case 'DHL Germany':
                return sprintf('https://nolp.dhl.de/nextt-online-public/set_identcodes.do?runtime=standalone&idc=%s', $this->tracking_number);
                break;
            case 'DPD':
                return sprintf('https://tracking.dpd.de/parcelstatus?locale=%s&query=%s', 'en_EN', $this->tracking_number);
                break;
            case 'Fadello':
                return sprintf('https://www.fadello.nl/livetracker?c=%s&pc=%s', $this->tracking_number, $this->postal_code);
                break;
            case 'PostNL':
                return sprintf('https://jouw.postnl.nl/#!/track-en-trace/%s/%s/%s', $this->tracking_number, $this->country['iso_2'], $this->postal_code);
                break;
            default:
                return null;
                break;
        }
    }

    public function getShipperName()
    {
        foreach ($this->shipperShippingMethodIds as $shipper => $methodIdArray) {
            if (in_array($this->shipment['id'], $methodIdArray)) {
                return $shipper;
            }
        }

        return null;
    }
    
    public function getStatuses() {
        $result = $this->connection()->get($this->url . '/statuses');
        return $result;
    }
}
