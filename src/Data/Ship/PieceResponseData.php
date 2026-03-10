<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class PieceResponseData extends Data
{
    public function __construct(
        public ?float $netChargeAmount,
        public ?string $acceptanceTrackingNumber,
        public ?string $serviceCategory,
        public ?string $deliveryTimestamp,
        public ?string $trackingIdType,
        public ?float $baseRateAmount,
        public ?int $packageSequenceNumber,
        public ?string $masterTrackingNumber,
        public ?string $trackingNumber,
        #[DataCollectionOf(LabelResponseData::class)]
        public ?array $packageDocuments,
        #[DataCollectionOf(CustomerReferenceData::class)]
        public ?array $customerReferences,
    ) {}
}
