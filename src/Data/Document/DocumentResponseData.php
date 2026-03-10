<?php

namespace SmartDato\FedEx\Data\Document;

use Spatie\LaravelData\Data;

class DocumentResponseData extends Data
{
    public function __construct(
        public ?string $customerTransactionId,
        public ?DocumentOutputData $output,
    ) {}
}
