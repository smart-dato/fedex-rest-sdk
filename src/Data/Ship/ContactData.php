<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class ContactData extends Data
{
    public function __construct(
        public string $phoneNumber,
        public string|Optional $personName,
        public string|Optional $emailAddress,
        public string|Optional $phoneExtension,
        public string|Optional $companyName,
    ) {}
}
