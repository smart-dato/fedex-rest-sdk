<?php

namespace SmartDato\FedEx\Data\Document;

use Spatie\LaravelData\Data;

class DocumentOutputData extends Data
{
    public function __construct(
        public ?DocumentMetaOutputData $meta,
    ) {}
}
