# FedEx REST SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/smart-dato/fedex-rest-sdk.svg?style=flat-square)](https://packagist.org/packages/smart-dato/fedex-rest-sdk)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/smart-dato/fedex-rest-sdk/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/smart-dato/fedex-rest-sdk/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/smart-dato/fedex-rest-sdk/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/smart-dato/fedex-rest-sdk/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/smart-dato/fedex-rest-sdk.svg?style=flat-square)](https://packagist.org/packages/smart-dato/fedex-rest-sdk)

Laravel package for integrating with the FedEx REST APIs. Supports shipment creation, cancellation, validation, tag management, and trade document uploads. Built on [Saloon 3.x](https://docs.saloon.dev) for HTTP and [Spatie Laravel Data 4.x](https://spatie.be/docs/laravel-data) for DTOs.

## Requirements

- PHP 8.4+
- Laravel 11 or 12

## Installation

Install the package via Composer:

```bash
composer require smart-dato/fedex-rest-sdk
```

Publish the config file:

```bash
php artisan vendor:publish --tag="fedex-rest-sdk-config"
```

## Configuration

Add the following environment variables to your `.env` file:

```env
FEDEX_CLIENT_ID=your-client-id
FEDEX_CLIENT_SECRET=your-client-secret
FEDEX_ACCOUNT_NUMBER=your-account-number
```

The published config file (`config/fedex-rest-sdk.php`) contains all available options:

```php
return [
    'client_id' => env('FEDEX_CLIENT_ID'),
    'client_secret' => env('FEDEX_CLIENT_SECRET'),
    'account_number' => env('FEDEX_ACCOUNT_NUMBER'),

    'grant_type' => env('FEDEX_GRANT_TYPE', 'client_credentials'),
    'child_key' => env('FEDEX_CHILD_KEY'),
    'child_secret' => env('FEDEX_CHILD_SECRET'),

    'base_url' => env('FEDEX_BASE_URL', 'https://apis.fedex.com'),
    'document_base_url' => env('FEDEX_DOCUMENT_BASE_URL', 'https://documentapi.prod.fedex.com'),

    'verify_ssl' => env('FEDEX_VERIFY_SSL', true),
];
```

For the **sandbox** environment, override the URLs:

```env
FEDEX_BASE_URL=https://apis-sandbox.fedex.com
FEDEX_DOCUMENT_BASE_URL=https://documentapitest.prod.fedex.com/sandbox
```

### Authentication Grant Types

The SDK supports three FedEx authentication modes:

- `client_credentials` — Standard B2B (default)
- `csp_credentials` — Compatible/Integrator customers with child accounts
- `client_pc_credentials` — Proprietary Parent-Child customers

For CSP or Parent-Child authentication, also set:

```env
FEDEX_GRANT_TYPE=csp_credentials
FEDEX_CHILD_KEY=your-child-key
FEDEX_CHILD_SECRET=your-child-secret
```

## Usage

Resolve the SDK from the container (or use the `FedEx` facade):

```php
use SmartDato\FedEx\FedEx;

$fedex = app(FedEx::class);
```

### Create a Shipment

```php
use SmartDato\FedEx\Data\Ship\CreateShipmentData;

$request = CreateShipmentData::from([
    'accountNumber' => ['value' => '123456789'],
    'labelResponseOptions' => 'URL_ONLY',
    'requestedShipment' => [
        'shipper' => [
            'address' => [
                'streetLines' => ['123 Ship Street'],
                'city' => 'Memphis',
                'stateOrProvinceCode' => 'TN',
                'postalCode' => '38116',
                'countryCode' => 'US',
            ],
            'contact' => [
                'personName' => 'John Shipper',
                'phoneNumber' => '1234567890',
                'companyName' => 'Shipper Co',
            ],
        ],
        'recipients' => [
            [
                'address' => [
                    'streetLines' => ['456 Recipient Ave'],
                    'city' => 'Los Angeles',
                    'stateOrProvinceCode' => 'CA',
                    'postalCode' => '90001',
                    'countryCode' => 'US',
                ],
                'contact' => [
                    'personName' => 'Jane Recipient',
                    'phoneNumber' => '0987654321',
                    'companyName' => 'Recipient Inc',
                ],
            ],
        ],
        'pickupType' => 'DROPOFF_AT_FEDEX_LOCATION',
        'serviceType' => 'STANDARD_OVERNIGHT',
        'packagingType' => 'YOUR_PACKAGING',
        'totalWeight' => 10.0,
        'shippingChargesPayment' => [
            'paymentType' => 'SENDER',
        ],
        'labelSpecification' => [
            'imageType' => 'PDF',
            'labelStockType' => 'PAPER_4X6',
        ],
        'requestedPackageLineItems' => [
            [
                'weight' => [
                    'units' => 'LB',
                    'value' => 10.0,
                ],
            ],
        ],
    ],
]);

$response = $fedex->ship()->createShipment($request);

$response->transactionId;
$response->output->transactionShipments[0]->masterTrackingNumber;
$response->output->transactionShipments[0]->pieceResponses[0]->trackingNumber;
```

### Validate a Shipment

```php
use SmartDato\FedEx\Data\Ship\ValidateShipmentData;

$request = ValidateShipmentData::from([
    'accountNumber' => ['value' => '123456789'],
    'requestedShipment' => [
        // Same structure as create shipment
    ],
]);

$response = $fedex->ship()->validateShipment($request);

foreach ($response->output->alerts as $alert) {
    $alert->code;       // "SHIPMENT.VALIDATION.SUCCESS"
    $alert->alertType;  // "NOTE"
    $alert->message;
}
```

### Cancel a Shipment

```php
use SmartDato\FedEx\Data\Ship\CancelShipmentData;

$request = CancelShipmentData::from([
    'accountNumber' => ['value' => '123456789'],
    'trackingNumber' => '794644790138',
]);

$response = $fedex->ship()->cancelShipment($request);

$response->output->cancelledShipment;  // true
```

### Create and Cancel Tags

```php
use SmartDato\FedEx\Data\Ship\CreateTagData;
use SmartDato\FedEx\Data\Ship\CancelTagData;

// Create a tag
$response = $fedex->ship()->createTag(CreateTagData::from([
    'accountNumber' => ['value' => '123456789'],
    'requestedShipment' => [/* ... */],
]));

$response->output->masterTrackingNumber;
$response->output->completedTagDetail->confirmationNumber;

// Cancel a tag
$fedex->ship()->cancelTag(CancelTagData::from([
    'accountNumber' => ['value' => '123456789'],
    'serviceType' => 'PRIORITY_OVERNIGHT',
    'completedTagDetail' => [
        'confirmationNumber' => 'CONF123',
    ],
]), shipmentId: 'SHIP123');
```

### Retrieve Async Shipment Results

For shipments with 40+ packages processed asynchronously:

```php
use SmartDato\FedEx\Data\Ship\AsyncResultsData;

$response = $fedex->ship()->retrieveAsyncResults(AsyncResultsData::from([
    'accountNumber' => ['value' => '123456789'],
    'jobId' => '624deea6-b709-470c-8c39-4b5511281492',
]));
```

### Upload Trade Documents

```php
use SmartDato\FedEx\Data\Document\UploadDocumentData;

$data = UploadDocumentData::from([
    'workflowName' => 'ETDPreshipment',
    'name' => 'commercial_invoice.pdf',
    'contentType' => 'application/pdf',
    'meta' => [
        'shipDocumentType' => 'COMMERCIAL_INVOICE',
        'originCountryCode' => 'US',
        'destinationCountryCode' => 'CA',
    ],
]);

$response = $fedex->documents()->uploadDocument($data, '/path/to/commercial_invoice.pdf');

$response->output->meta->docId;        // Use this in your shipment request
$response->output->meta->documentType;  // "CI"
```

### Upload Multiple Documents

```php
use SmartDato\FedEx\Data\Document\MultiUploadDocumentData;

$data = MultiUploadDocumentData::from([
    'workflowName' => 'ETDPreshipment',
    'carrierCode' => 'FDXE',
    'originCountryCode' => 'US',
    'destinationCountryCode' => 'CA',
    'metaData' => [
        [
            'fileName' => 'invoice.pdf',
            'contentType' => 'application/pdf',
            'shipDocumentType' => 'COMMERCIAL_INVOICE',
        ],
        [
            'fileName' => 'certificate.pdf',
            'contentType' => 'application/pdf',
            'shipDocumentType' => 'CERTIFICATE_OF_ORIGIN',
        ],
    ],
]);

$response = $fedex->documents()->multiUploadDocuments($data, [
    '/path/to/invoice.pdf',
    '/path/to/certificate.pdf',
]);

foreach ($response->output->documentResponses as $doc) {
    $doc->docId;
    $doc->documentType;
}
```

### Upload Letterhead/Signature Images

```php
use SmartDato\FedEx\Data\Document\ImageDocumentData;

$data = ImageDocumentData::from([
    'referenceId' => '1234',
    'name' => 'signature.png',
    'contentType' => 'image/png',
    'workflowName' => 'LetterheadSignature',
    'meta' => [
        'imageType' => 'SIGNATURE',
        'imageIndex' => 'IMAGE_1',
    ],
]);

$response = $fedex->documents()->uploadImage($data, '/path/to/signature.png');

$response->output->status;               // "SUCCESS"
$response->output->documentReferenceId;   // "1234"
```

### Using the Facade

```php
use SmartDato\FedEx\Facades\FedEx;

$response = FedEx::ship()->createShipment($request);
$labels = FedEx::documents()->uploadDocument($data, $filePath);
```

### On-the-fly Instantiation

Create instances without the Laravel container, useful for multiple accounts or non-Laravel usage:

```php
use SmartDato\FedEx\FedEx;

$fedex = FedEx::make([
    'client_id' => 'your-client-id',
    'client_secret' => 'your-client-secret',
    'base_url' => 'https://apis-sandbox.fedex.com',
    'document_base_url' => 'https://documentapitest.prod.fedex.com/sandbox',
]);

$response = $fedex->ship()->createShipment($request);
```

### Accessing Raw Request/Response

After any API call, you can inspect the raw Saloon request and response for debugging or logging:

```php
$response = $fedex->ship()->createShipment($request);

$fedex->ship()->lastRequest();    // Saloon\Http\Request
$fedex->ship()->lastResponse();   // Saloon\Http\Response

// Same for documents
$fedex->documents()->lastRequest();
$fedex->documents()->lastResponse();
```

## Available Enums

The package provides typed enums for API constants:

```php
use SmartDato\FedEx\Enums\PaymentType;       // SENDER, RECIPIENT, THIRD_PARTY, COLLECT
use SmartDato\FedEx\Enums\PickupType;        // CONTACT_FEDEX_TO_SCHEDULE, DROPOFF_AT_FEDEX_LOCATION, USE_SCHEDULED_PICKUP
use SmartDato\FedEx\Enums\WeightUnit;        // KG, LB
use SmartDato\FedEx\Enums\DimensionUnit;     // CM, IN
use SmartDato\FedEx\Enums\ImageType;         // ZPLII, EPL2, PDF, PNG
use SmartDato\FedEx\Enums\LabelStockType;    // PAPER_4X6, STOCK_4X675, PAPER_4X675, PAPER_4X8, PAPER_4X9, PAPER_7X475
use SmartDato\FedEx\Enums\LabelFormatType;   // COMMON2D, LABEL_DATA_ONLY
use SmartDato\FedEx\Enums\DeletionControl;   // DELETE_ALL_PACKAGES, DELETE_ONE_PACKAGE, LEGACY
use SmartDato\FedEx\Enums\ShipDocumentType;  // CERTIFICATE_OF_ORIGIN, COMMERCIAL_INVOICE, ETD_LABEL, ...
use SmartDato\FedEx\Enums\WorkflowName;      // ETDPreshipment, ETDPostshipment
use SmartDato\FedEx\Enums\CarrierCode;       // FDXE, FDXG
```

## Error Handling

API errors are thrown as `FedExApiException`:

```php
use SmartDato\FedEx\Exceptions\FedExApiException;

try {
    $response = $fedex->ship()->createShipment($request);
} catch (FedExApiException $e) {
    $e->getMessage();       // Error message from the API
    $e->getCode();          // HTTP status code
    $e->errorCode;          // FedEx error code (e.g., "NOT.AUTHORIZED.ERROR")
    $e->transactionId;      // Transaction ID for support reference
}
```

## Testing

```bash
composer test             # Run tests
composer analyse          # Static analysis (PHPStan level 5)
composer format           # Code style (Laravel Pint)
composer test-coverage    # Tests with coverage report
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [SmartDato](https://github.com/smart-dato)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
