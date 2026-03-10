<?php

namespace SmartDato\FedEx\Connectors;

class ShipConnector extends FedExConnector
{
    public function resolveBaseUrl(): string
    {
        return $this->baseUrl ?? (string) config('fedex-rest-sdk.base_url', 'https://apis.fedex.com');
    }
}
