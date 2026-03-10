<?php

namespace SmartDato\FedEx\Data\Document;

use Spatie\LaravelData\Data;

class ImageMetaInputData extends Data
{
    public function __construct(
        public string $imageType,
        public string $imageIndex,
    ) {}
}
