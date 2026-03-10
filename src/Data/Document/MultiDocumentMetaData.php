<?php

namespace SmartDato\FedEx\Data\Document;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class MultiDocumentMetaData extends Data
{
    public function __construct(
        public string $fileName,
        public string $contentType,
        public string $shipDocumentType,
        public string|Optional $fileReferenceId,
        public string|Optional $formCode,
        public string|Optional $originLocationCode,
        public string|Optional $destinationLocationCode,
    ) {}
}
