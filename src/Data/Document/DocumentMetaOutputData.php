<?php

namespace SmartDato\FedEx\Data\Document;

use Spatie\LaravelData\Data;

class DocumentMetaOutputData extends Data
{
    public function __construct(
        public ?string $documentType,
        public ?string $docId,
        public ?string $folderId,
    ) {}
}
