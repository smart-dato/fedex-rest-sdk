<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CompletedTagDetailData extends Data
{
    public function __construct(
        public string|Optional $confirmationNumber,
        public string|Optional $location,
        public string|Optional $dispatchDate,
    ) {}
}
