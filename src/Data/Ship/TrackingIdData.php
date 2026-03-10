<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class TrackingIdData extends Data
{
    public function __construct(
        public string|Optional $formId,
        public string|Optional $trackingIdType,
        public string|Optional $uspsApplicationId,
        public string|Optional $trackingNumber,
    ) {}
}
