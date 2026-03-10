<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class RecipientPartyData extends Data
{
    public function __construct(
        public AddressData $address,
        public ContactData $contact,
        #[DataCollectionOf(TaxpayerIdentificationData::class)]
        public array|Optional $tins,
        public string|Optional $deliveryInstructions,
    ) {}
}
