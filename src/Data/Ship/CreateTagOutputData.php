<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class CreateTagOutputData extends Data
{
    public function __construct(
        public ?string $masterTrackingNumber,
        public ?string $serviceType,
        public ?string $shipTimestamp,
        public ?CompletedTagDetailData $completedTagDetail,
        #[DataCollectionOf(AlertData::class)]
        public ?array $alerts,
    ) {}
}
