<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use SmartDato\FedEx\Auth\FedExAuthenticator;
use SmartDato\FedEx\Connectors\ShipConnector;
use SmartDato\FedEx\Data\Ship\CancelShipmentData;
use SmartDato\FedEx\Data\Ship\CancelShipmentResponseData;
use SmartDato\FedEx\Data\Ship\CreateShipmentData;
use SmartDato\FedEx\Data\Ship\ShipmentResponseData;
use SmartDato\FedEx\Data\Ship\ValidateShipmentData;
use SmartDato\FedEx\Data\Ship\ValidateShipmentResponseData;
use SmartDato\FedEx\Requests\Ship\CancelShipmentRequest;
use SmartDato\FedEx\Requests\Ship\CreateShipmentRequest;
use SmartDato\FedEx\Requests\Ship\ValidateShipmentRequest;
use SmartDato\FedEx\Resources\ShipResource;

beforeEach(function () {
    Cache::put('fedex_oauth_token_'.md5('test-idclient_credentials'), 'fake-token', 3600);
});

function shipConnector(): ShipConnector
{
    return new ShipConnector(
        fedExAuthenticator: new FedExAuthenticator('test-id', 'test-secret', 'https://apis-sandbox.fedex.com'),
        baseUrl: 'https://apis-sandbox.fedex.com',
    );
}

function fixtureJson(string $path): array
{
    return json_decode(file_get_contents(__DIR__.'/../Fixtures/'.$path), true);
}

it('creates a shipment and returns shipment response', function () {
    $mockClient = new MockClient([
        CreateShipmentRequest::class => MockResponse::make(fixtureJson('ship/create_shipment_response.json')),
    ]);

    $connector = shipConnector();
    $connector->withMockClient($mockClient);
    $resource = new ShipResource($connector);

    $requestData = CreateShipmentData::from(fixtureJson('ship/create_shipment_request.json'));
    $response = $resource->createShipment($requestData);

    expect($response)
        ->toBeInstanceOf(ShipmentResponseData::class)
        ->and($response->transactionId)->toBe('624deea6-b709-470c-8c39-4b5511281492')
        ->and($response->output->transactionShipments)->toHaveCount(1)
        ->and($response->output->transactionShipments[0]->masterTrackingNumber)->toBe('794644790138')
        ->and($response->output->transactionShipments[0]->serviceType)->toBe('STANDARD_OVERNIGHT')
        ->and($response->output->transactionShipments[0]->pieceResponses[0]->trackingNumber)->toBe('794644790138');

    $mockClient->assertSent(CreateShipmentRequest::class);

    expect($resource->lastRequest())->toBeInstanceOf(CreateShipmentRequest::class);
    expect($resource->lastResponse())->not->toBeNull();
});

it('cancels a shipment and returns cancel response', function () {
    $mockClient = new MockClient([
        CancelShipmentRequest::class => MockResponse::make(fixtureJson('ship/cancel_shipment_response.json')),
    ]);

    $connector = shipConnector();
    $connector->withMockClient($mockClient);
    $resource = new ShipResource($connector);

    $requestData = CancelShipmentData::from([
        'accountNumber' => ['value' => '123456789'],
        'trackingNumber' => '794644790138',
    ]);
    $response = $resource->cancelShipment($requestData);

    expect($response)
        ->toBeInstanceOf(CancelShipmentResponseData::class)
        ->and($response->output->cancelledShipment)->toBeTrue()
        ->and($response->output->message)->toBe('Shipment cancelled successfully.');

    $mockClient->assertSent(CancelShipmentRequest::class);
});

it('validates a shipment and returns validate response', function () {
    $mockClient = new MockClient([
        ValidateShipmentRequest::class => MockResponse::make(fixtureJson('ship/validate_shipment_response.json')),
    ]);

    $connector = shipConnector();
    $connector->withMockClient($mockClient);
    $resource = new ShipResource($connector);

    $requestData = ValidateShipmentData::from([
        'accountNumber' => ['value' => '123456789'],
        'requestedShipment' => fixtureJson('ship/create_shipment_request.json')['requestedShipment'],
    ]);
    $response = $resource->validateShipment($requestData);

    expect($response)
        ->toBeInstanceOf(ValidateShipmentResponseData::class)
        ->and($response->output->alerts)->toHaveCount(1)
        ->and($response->output->alerts[0]->code)->toBe('SHIPMENT.VALIDATION.SUCCESS');

    $mockClient->assertSent(ValidateShipmentRequest::class);
});

it('builds FedEx on the fly with make()', function () {
    $fedex = \SmartDato\FedEx\FedEx::make([
        'client_id' => 'test-id',
        'client_secret' => 'test-secret',
        'base_url' => 'https://apis-sandbox.fedex.com',
    ]);

    expect($fedex->ship())->toBeInstanceOf(ShipResource::class);
    expect($fedex->documents())->toBeInstanceOf(\SmartDato\FedEx\Resources\DocumentResource::class);
});
