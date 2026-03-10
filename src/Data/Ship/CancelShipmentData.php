<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CancelShipmentData extends Data
{
    public function __construct(
        public AccountNumberData $accountNumber,
        public string $trackingNumber,
        public bool|Optional $emailShipment,
        public string|Optional $senderCountryCode,
        public string|Optional $deletionControl,
    ) {}
}
