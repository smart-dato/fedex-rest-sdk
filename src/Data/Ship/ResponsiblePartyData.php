<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class ResponsiblePartyData extends Data
{
    public function __construct(
        public AddressData|Optional $address,
        public ContactData|Optional $contact,
        public AccountNumberData|Optional $accountNumber,
    ) {}
}
