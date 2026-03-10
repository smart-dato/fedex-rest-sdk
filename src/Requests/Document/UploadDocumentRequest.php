<?php

namespace SmartDato\FedEx\Requests\Document;

use Saloon\Contracts\Body\HasBody;
use Saloon\Data\MultipartValue;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasMultipartBody;
use SmartDato\FedEx\Data\Document\DocumentResponseData;
use SmartDato\FedEx\Data\Document\UploadDocumentData;

class UploadDocumentRequest extends Request implements HasBody
{
    use HasMultipartBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected UploadDocumentData $data,
        protected string $filePath,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/documents/v1/etds/upload';
    }

    protected function defaultBody(): array
    {
        return [
            new MultipartValue('document', json_encode($this->data->toArray()), 'document.json', ['Content-Type' => 'application/json']),
            new MultipartValue('attachment', file_get_contents($this->filePath), basename($this->filePath)),
        ];
    }

    public function createDtoFromResponse(Response $response): DocumentResponseData
    {
        return DocumentResponseData::from($response->json());
    }
}
