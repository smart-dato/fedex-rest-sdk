<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class CancelShipmentOutputData extends Data
{
    public function __construct(
        public ?bool $cancelledShipment,
        public ?bool $cancelledHistory,
        public ?string $message,
        #[DataCollectionOf(AlertData::class)]
        public ?array $alerts,
    ) {}
}
