<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class LabelResponseData extends Data
{
    public function __construct(
        public ?string $contentKey,
        public ?int $copiesToPrint,
        public ?string $contentType,
        public ?string $trackingNumber,
        public ?string $docType,
        public ?string $encodedLabel,
        public ?string $url,
        #[DataCollectionOf(AlertData::class)]
        public ?array $alerts,
    ) {}
}
