<?php

namespace SmartDato\FedEx;

use SmartDato\FedEx\Auth\FedExAuthenticator;
use SmartDato\FedEx\Connectors\DocumentConnector;
use SmartDato\FedEx\Connectors\ShipConnector;
use SmartDato\FedEx\Resources\DocumentResource;
use SmartDato\FedEx\Resources\ShipResource;

class FedEx
{
    protected ?ShipResource $shipResource = null;

    protected ?DocumentResource $documentResource = null;

    public function __construct(
        protected ShipConnector $shipConnector,
        protected DocumentConnector $documentConnector,
    ) {}

    public static function make(array $config): self
    {
        $authenticator = new FedExAuthenticator(
            clientId: $config['client_id'],
            clientSecret: $config['client_secret'],
            baseUrl: $config['base_url'] ?? 'https://apis.fedex.com',
            grantType: $config['grant_type'] ?? 'client_credentials',
            childKey: $config['child_key'] ?? null,
            childSecret: $config['child_secret'] ?? null,
            verifySsl: $config['verify_ssl'] ?? true,
        );

        $verifySsl = $config['verify_ssl'] ?? true;

        return new self(
            shipConnector: new ShipConnector(
                fedExAuthenticator: $authenticator,
                baseUrl: $config['base_url'] ?? null,
                verifySsl: $verifySsl,
            ),
            documentConnector: new DocumentConnector(
                fedExAuthenticator: $authenticator,
                baseUrl: $config['document_base_url'] ?? null,
                verifySsl: $verifySsl,
            ),
        );
    }

    public function ship(): ShipResource
    {
        return $this->shipResource ??= new ShipResource($this->shipConnector);
    }

    public function documents(): DocumentResource
    {
        return $this->documentResource ??= new DocumentResource($this->documentConnector);
    }
}
