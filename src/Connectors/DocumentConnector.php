<?php

namespace SmartDato\FedEx\Connectors;

class DocumentConnector extends FedExConnector
{
    public function resolveBaseUrl(): string
    {
        return $this->baseUrl ?? (string) config('fedex-rest-sdk.document_base_url', 'https://documentapi.prod.fedex.com');
    }
}
