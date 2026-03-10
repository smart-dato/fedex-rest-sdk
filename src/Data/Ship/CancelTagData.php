<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CancelTagData extends Data
{
    public function __construct(
        public AccountNumberData $accountNumber,
        public string $serviceType,
        public CompletedTagDetailData $completedTagDetail,
        public string|Optional $trackingNumber,
    ) {}
}
