<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;

class AccountNumberData extends Data
{
    public function __construct(
        public string $value,
    ) {}
}
