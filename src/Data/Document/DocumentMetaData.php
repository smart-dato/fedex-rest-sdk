<?php

namespace SmartDato\FedEx\Data\Document;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class DocumentMetaData extends Data
{
    public function __construct(
        public string $shipDocumentType,
        public string $originCountryCode,
        public string $destinationCountryCode,
        public string|Optional $formCode,
        public string|Optional $trackingNumber,
        public string|Optional $shipmentDate,
        public string|Optional $originLocationCode,
        public string|Optional $destinationLocationCode,
    ) {}
}
