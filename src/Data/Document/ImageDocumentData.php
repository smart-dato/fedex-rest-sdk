<?php

namespace SmartDato\FedEx\Data\Document;

use Spatie\LaravelData\Data;

class ImageDocumentData extends Data
{
    public function __construct(
        public string $referenceId,
        public string $name,
        public string $contentType,
        public ImageMetaInputData $meta,
        public string $workflowName,
    ) {}
}
