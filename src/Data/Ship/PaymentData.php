<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PaymentData extends Data
{
    public function __construct(
        public string $paymentType,
        public PayorData|Optional $payor,
    ) {}
}
