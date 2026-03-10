<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class TransactionShipmentData extends Data
{
    public function __construct(
        public ?string $serviceType,
        public ?string $shipDatestamp,
        public ?string $serviceCategory,
        public ?string $serviceName,
        public ?string $masterTrackingNumber,
        #[DataCollectionOf(LabelResponseData::class)]
        public ?array $shipmentDocuments,
        #[DataCollectionOf(PieceResponseData::class)]
        public ?array $pieceResponses,
        #[DataCollectionOf(AlertData::class)]
        public ?array $alerts,
    ) {}
}
