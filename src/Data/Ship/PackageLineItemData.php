<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PackageLineItemData extends Data
{
    public function __construct(
        public WeightData $weight,
        public int|Optional $sequenceNumber,
        public string|Optional $subPackagingType,
        #[DataCollectionOf(CustomerReferenceData::class)]
        public array|Optional $customerReferences,
        public MoneyData|Optional $declaredValue,
        public DimensionsData|Optional $dimensions,
        public int|Optional $groupPackageCount,
        public string|Optional $itemDescriptionForClearance,
        public string|Optional $itemDescription,
    ) {}
}
