<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class AlertData extends Data
{
    public function __construct(
        public string|Optional $code,
        public string|Optional $alertType,
        public string|Optional $message,
    ) {}
}
