<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CustomerReferenceData extends Data
{
    public function __construct(
        public string|Optional $customerReferenceType,
        public string|Optional $value,
    ) {}
}
