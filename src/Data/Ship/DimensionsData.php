<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;

class DimensionsData extends Data
{
    public function __construct(
        public int $length,
        public int $width,
        public int $height,
        public string $units,
    ) {}
}
