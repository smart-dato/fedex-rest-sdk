<?php

namespace SmartDato\FedEx\Data\Document;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class MultiUploadDocumentData extends Data
{
    public function __construct(
        public string $workflowName,
        public string $carrierCode,
        public string $originCountryCode,
        public string $destinationCountryCode,
        #[DataCollectionOf(MultiDocumentMetaData::class)]
        public array $metaData,
        public string|Optional $shipmentDate,
        public string|Optional $trackingNumber,
    ) {}
}
