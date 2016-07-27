<?php namespace Picqer\Carriers\SendCloud;

class Parcel extends Model
{

    use Query\Findable;
    use Persistance\Storable;

    protected $fillable = [
        'id',
        'name',
        'company_name',
        'address',
        'city',
        'postal_code',
        'telephone',
        'email',
        'data',
        'country',
        'shipment',
        'requestShipment',
        'order_number',
        'tracking_number'
    ];

    protected $url = 'parcels';

    protected $namespaces = [
        'singular' => 'parcel',
        'plural' => 'parcels'
    ];

    protected $shipperShippingMethodIds = [
        'BPost' => [54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 82, 83, 95, 96],
        'DHL' => [9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 38, 40, 53, 81],
        'DHL Germany' => [89, 90, 91, 92, 93, 94],
        'DPD' => [41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 85, 86, 87],
        'Fadello' => [88],
        'PostNL' => [1, 2, 3, 4, 5, 6, 7, 29, 30, 31, 32, 33, 34, 35, 36, 37, 39, 84],
    ];

    public function getTrackingUrl()
    {
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

    private function getShipperName()
    {
        foreach ($this->shipperShippingMethodIds as $shipper => $methodIdArray) {
            if (in_array($this->shipment['id'], $methodIdArray)) {
                return $shipper;
            }
        }
    }
}
