<?php namespace Picqer\Carriers\SendCloud;

class Label extends Model {

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
}
