<?php

namespace Picqer\Carriers\SendCloud;

class DocumentDownloader
{
    public const FILE_FORMAT_PDF = 'pdf';
    public const FILE_FORMAT_ZPL = 'zpl';
    public const FILE_FORMAT_PNG = 'png';

    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getDocument(string $documentUrl, string $fileFormat = self::FILE_FORMAT_PDF): string
    {
        $headers = $this->getHeadersForFileFormat($fileFormat);

        return $this->connection->download($documentUrl, $headers);
    }

    private function getHeadersForFileFormat(string $fileFormat): array
    {
        if ($fileFormat === self::FILE_FORMAT_ZPL) {
            return ['Accept' => 'application/zpl'];
        }

        if ($fileFormat === self::FILE_FORMAT_PNG) {
            return ['Accept' => 'image/png'];
        }

        return ['Accept' => 'application/pdf'];
    }
}