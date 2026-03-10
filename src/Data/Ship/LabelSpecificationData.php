<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class LabelSpecificationData extends Data
{
    public function __construct(
        public string $imageType,
        public string $labelStockType,
        public string|Optional $labelFormatType,
        public string|Optional $labelOrder,
        public string|Optional $labelRotation,
        public string|Optional $labelPrintingOrientation,
        public int|Optional $resolution,
    ) {}
}
