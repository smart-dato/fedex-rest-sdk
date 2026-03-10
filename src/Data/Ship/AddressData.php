<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class AddressData extends Data
{
    public function __construct(
        public array $streetLines,
        public string $city,
        public string $countryCode,
        public string|Optional $stateOrProvinceCode,
        public string|Optional $postalCode,
        public bool|Optional $residential,
    ) {}
}
