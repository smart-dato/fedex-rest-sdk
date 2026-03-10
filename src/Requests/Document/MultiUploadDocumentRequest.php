<?php

namespace SmartDato\FedEx\Requests\Document;

use Saloon\Contracts\Body\HasBody;
use Saloon\Data\MultipartValue;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasMultipartBody;
use SmartDato\FedEx\Data\Document\MultiDocumentResponseData;
use SmartDato\FedEx\Data\Document\MultiUploadDocumentData;

class MultiUploadDocumentRequest extends Request implements HasBody
{
    use HasMultipartBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected MultiUploadDocumentData $data,
        protected array $filePaths,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/documents/v1/etds/multiupload';
    }

    protected function defaultBody(): array
    {
        $parts = [
            new MultipartValue('documentInformation', json_encode($this->data->toArray()), 'documentInformation.json', ['Content-Type' => 'application/json']),
        ];

        foreach ($this->filePaths as $filePath) {
            $parts[] = new MultipartValue('fileAttachments', file_get_contents($filePath), basename($filePath));
        }

        return $parts;
    }

    public function createDtoFromResponse(Response $response): MultiDocumentResponseData
    {
        return MultiDocumentResponseData::from($response->json());
    }
}
