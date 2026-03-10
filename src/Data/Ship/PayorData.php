<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PayorData extends Data
{
    public function __construct(
        public ResponsiblePartyData|Optional $responsibleParty,
    ) {}
}
