<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CreateShipmentData extends Data
{
    public function __construct(
        public AccountNumberData $accountNumber,
        public string $labelResponseOptions,
        public RequestedShipmentData $requestedShipment,
        public string|Optional $mergeLabelDocOption,
        public string|Optional $shipAction,
        public string|Optional $processingOptionType,
        public bool|Optional $oneLabelAtATime,
    ) {}
}
