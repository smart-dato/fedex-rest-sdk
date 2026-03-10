<?php

namespace SmartDato\FedEx\Data\Document;

use Spatie\LaravelData\Data;

class ImageOutputData extends Data
{
    public function __construct(
        public ?string $status,
        public ?string $documentReferenceId,
        public ?ImageMetaOutputData $meta,
    ) {}
}
