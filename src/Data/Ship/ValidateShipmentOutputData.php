<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class ValidateShipmentOutputData extends Data
{
    public function __construct(
        #[DataCollectionOf(AlertData::class)]
        public ?array $alerts,
    ) {}
}
