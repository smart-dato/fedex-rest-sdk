<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class CancelTagResponseData extends Data
{
    public function __construct(
        public ?string $transactionId,
        public ?string $customerTransactionId,
        #[DataCollectionOf(AlertData::class)]
        public ?array $alerts,
    ) {}
}
