<?php

namespace SmartDato\FedEx\Data\Document;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class MultiDocumentOutputData extends Data
{
    public function __construct(
        #[DataCollectionOf(MultiDocumentResponseItemData::class)]
        public ?array $documentResponses,
    ) {}
}
