<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;

class WeightData extends Data
{
    public function __construct(
        public string $units,
        public float $value,
    ) {}
}
