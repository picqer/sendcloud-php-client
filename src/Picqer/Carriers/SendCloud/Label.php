<?php

namespace Picqer\Carriers\SendCloud;

/**
 * Class Label
 *
 * @property string[] $normal_printer
 * @property string $label_printer
 *
 * @package Picqer\Carriers\SendCloud
 */
class Label extends Model
{

    use Query\FindOne;

    protected $fillable = [
        'normal_printer',
        'label_printer',
    ];

    protected $url = 'labels';

    protected $namespaces = [
        'singular' => 'label',
        'plural' => 'labels'
    ];

    /**
     * Returns the label content (PDF) in A6 format.
     *
     * @return string
     */
    public function labelPrinterContent()
    {
        $url = str_replace($this->connection->apiUrl(), '', $this->label_printer);

        return $this->connection->download($url);
    }

    /**
     * Returns the label content (PDF) in A4 format
     *
     * @param int $position (0: Left Top, 1: Right Top, 2: Left bottom, 3: Right bottom)
     * @return string
     * @throws SendCloudApiException
     */

    public function normalPrinterContent($position = 0)
    {
        $url = str_replace($this->connection->apiUrl(), '', $this->normal_printer[$position]);

        return $this->connection->download($url);
    }
}
