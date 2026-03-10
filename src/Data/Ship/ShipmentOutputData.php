<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class ShipmentOutputData extends Data
{
    public function __construct(
        #[DataCollectionOf(TransactionShipmentData::class)]
        public ?array $transactionShipments,
        #[DataCollectionOf(AlertData::class)]
        public ?array $alerts,
        public ?string $jobId,
    ) {}
}
