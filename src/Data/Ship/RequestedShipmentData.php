<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class RequestedShipmentData extends Data
{
    public function __construct(
        public PartyData $shipper,
        #[DataCollectionOf(RecipientPartyData::class)]
        public array $recipients,
        public string $pickupType,
        public string $serviceType,
        public string $packagingType,
        public float $totalWeight,
        public PaymentData $shippingChargesPayment,
        public LabelSpecificationData $labelSpecification,
        #[DataCollectionOf(PackageLineItemData::class)]
        public array $requestedPackageLineItems,
        public string|Optional $shipDatestamp,
        public MoneyData|Optional $totalDeclaredValue,
        public int|Optional $totalPackageCount,
        public string|Optional $preferredCurrency,
        public bool|Optional $blockInsightVisibility,
        public string|Optional $recipientLocationNumber,
        public array|Optional $rateRequestType,
    ) {}
}
