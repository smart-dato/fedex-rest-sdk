<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;

class MoneyData extends Data
{
    public function __construct(
        public float $amount,
        public string $currency,
    ) {}
}
