<?php

namespace SmartDato\FedEx\Data\Document;

use Spatie\LaravelData\Data;

class MultiDocumentResponseItemData extends Data
{
    public function __construct(
        public ?string $fileReferenceId,
        public ?string $formCode,
        public ?string $documentType,
        public ?string $docId,
        public ?string $folderId,
    ) {}
}
