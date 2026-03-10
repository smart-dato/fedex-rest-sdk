<?php

namespace SmartDato\FedEx\Connectors;

use Saloon\Contracts\Authenticator;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use SmartDato\FedEx\Auth\FedExAuthenticator;
use SmartDato\FedEx\Exceptions\FedExApiException;

abstract class FedExConnector extends Connector
{
    public function __construct(
        protected FedExAuthenticator $fedExAuthenticator,
        protected ?string $baseUrl = null,
        protected bool $verifySsl = true,
    ) {}

    protected function defaultConfig(): array
    {
        return [
            'verify' => $this->verifySsl,
        ];
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    protected function defaultAuth(): ?Authenticator
    {
        return $this->fedExAuthenticator;
    }

    public function getRequestException(Response $response, ?\Throwable $senderException): ?\Throwable
    {
        return FedExApiException::fromResponse($response);
    }
}
