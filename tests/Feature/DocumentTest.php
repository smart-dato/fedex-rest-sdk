<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use SmartDato\FedEx\Auth\FedExAuthenticator;
use SmartDato\FedEx\Connectors\DocumentConnector;
use SmartDato\FedEx\Data\Document\DocumentResponseData;
use SmartDato\FedEx\Data\Document\UploadDocumentData;
use SmartDato\FedEx\Requests\Document\UploadDocumentRequest;
use SmartDato\FedEx\Resources\DocumentResource;

beforeEach(function () {
    Cache::put('fedex_oauth_token_'.md5('test-idclient_credentials'), 'fake-token', 3600);
});

function documentConnector(): DocumentConnector
{
    return new DocumentConnector(
        fedExAuthenticator: new FedExAuthenticator('test-id', 'test-secret', 'https://apis-sandbox.fedex.com'),
        baseUrl: 'https://documentapitest.prod.fedex.com/sandbox',
    );
}

function documentFixtureJson(string $path): array
{
    return json_decode(file_get_contents(__DIR__.'/../Fixtures/'.$path), true);
}

it('uploads a document and returns document response', function () {
    $mockClient = new MockClient([
        UploadDocumentRequest::class => MockResponse::make(documentFixtureJson('document/upload_response.json'), 201),
    ]);

    $connector = documentConnector();
    $connector->withMockClient($mockClient);
    $resource = new DocumentResource($connector);

    $data = UploadDocumentData::from([
        'workflowName' => 'ETDPreshipment',
        'name' => 'test.txt',
        'contentType' => 'text/plain',
        'meta' => [
            'shipDocumentType' => 'COMMERCIAL_INVOICE',
            'originCountryCode' => 'US',
            'destinationCountryCode' => 'CA',
        ],
    ]);

    // Create a temporary file for testing
    $tempFile = tempnam(sys_get_temp_dir(), 'fedex_test_');
    file_put_contents($tempFile, 'test content');

    try {
        $response = $resource->uploadDocument($data, $tempFile);

        expect($response)
            ->toBeInstanceOf(DocumentResponseData::class)
            ->and($response->output->meta->docId)->toBe('090493e181586308')
            ->and($response->output->meta->documentType)->toBe('CI')
            ->and($response->output->meta->folderId)->toBe('0b0493e1812f8921');

        $mockClient->assertSent(UploadDocumentRequest::class);

        expect($resource->lastRequest())->toBeInstanceOf(UploadDocumentRequest::class);
        expect($resource->lastResponse())->not->toBeNull();
    } finally {
        @unlink($tempFile);
    }
});
