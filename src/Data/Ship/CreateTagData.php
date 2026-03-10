<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;

class CreateTagData extends Data
{
    public function __construct(
        public AccountNumberData $accountNumber,
        public RequestedShipmentData $requestedShipment,
    ) {}
}
