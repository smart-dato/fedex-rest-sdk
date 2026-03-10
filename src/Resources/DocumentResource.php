<?php

namespace SmartDato\FedEx\Resources;

use Saloon\Http\Request;
use Saloon\Http\Response;
use SmartDato\FedEx\Connectors\DocumentConnector;
use SmartDato\FedEx\Data\Document\DocumentResponseData;
use SmartDato\FedEx\Data\Document\ImageDocumentData;
use SmartDato\FedEx\Data\Document\ImageResponseData;
use SmartDato\FedEx\Data\Document\MultiDocumentResponseData;
use SmartDato\FedEx\Data\Document\MultiUploadDocumentData;
use SmartDato\FedEx\Data\Document\UploadDocumentData;
use SmartDato\FedEx\Requests\Document\EncodedMultiUploadDocumentRequest;
use SmartDato\FedEx\Requests\Document\MultiUploadDocumentRequest;
use SmartDato\FedEx\Requests\Document\UploadDocumentRequest;
use SmartDato\FedEx\Requests\Document\UploadImageRequest;

class DocumentResource
{
    protected ?Request $lastRequest = null;

    protected ?Response $lastResponse = null;

    public function __construct(
        protected DocumentConnector $connector,
    ) {}

    public function lastRequest(): ?Request
    {
        return $this->lastRequest;
    }

    public function lastResponse(): ?Response
    {
        return $this->lastResponse;
    }

    public function uploadDocument(UploadDocumentData $data, string $filePath): DocumentResponseData
    {
        return $this->send(new UploadDocumentRequest($data, $filePath))->dtoOrFail();
    }

    public function uploadImage(ImageDocumentData $data, string $filePath): ImageResponseData
    {
        return $this->send(new UploadImageRequest($data, $filePath))->dtoOrFail();
    }

    public function multiUploadDocuments(MultiUploadDocumentData $data, array $filePaths): MultiDocumentResponseData
    {
        return $this->send(new MultiUploadDocumentRequest($data, $filePaths))->dtoOrFail();
    }

    public function encodedMultiUploadDocuments(MultiUploadDocumentData $data, array $filePaths): MultiDocumentResponseData
    {
        return $this->send(new EncodedMultiUploadDocumentRequest($data, $filePaths))->dtoOrFail();
    }

    protected function send(Request $request): Response
    {
        $this->lastRequest = $request;
        $this->lastResponse = $this->connector->send($request);

        return $this->lastResponse;
    }
}
