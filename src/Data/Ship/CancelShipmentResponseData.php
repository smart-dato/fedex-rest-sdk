<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;

class CancelShipmentResponseData extends Data
{
    public function __construct(
        public ?string $transactionId,
        public ?string $customerTransactionId,
        public ?CancelShipmentOutputData $output,
    ) {}
}
