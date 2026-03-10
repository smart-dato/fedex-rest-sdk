<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class TaxpayerIdentificationData extends Data
{
    public function __construct(
        public string|Optional $tinType,
        public string|Optional $number,
    ) {}
}
