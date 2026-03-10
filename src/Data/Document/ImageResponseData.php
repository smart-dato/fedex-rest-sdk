<?php

namespace SmartDato\FedEx\Data\Document;

use Spatie\LaravelData\Data;

class ImageResponseData extends Data
{
    public function __construct(
        public ?string $customerTransactionId,
        public ?ImageOutputData $output,
    ) {}
}
