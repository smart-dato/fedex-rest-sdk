<?php

namespace SmartDato\FedEx\Data\Document;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UploadDocumentData extends Data
{
    public function __construct(
        public string $workflowName,
        public string $name,
        public string $contentType,
        public DocumentMetaData $meta,
        public string|Optional $carrierCode,
    ) {}
}
