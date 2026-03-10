<?php

namespace SmartDato\FedEx\Data\Document;

use Spatie\LaravelData\Data;

class MultiDocumentResponseData extends Data
{
    public function __construct(
        public ?string $transactionId,
        public ?string $customerTransactionId,
        public ?MultiDocumentOutputData $output,
    ) {}
}
