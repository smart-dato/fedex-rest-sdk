<?php

namespace SmartDato\FedEx\Requests\Ship;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SmartDato\FedEx\Data\Ship\CancelShipmentData;
use SmartDato\FedEx\Data\Ship\CancelShipmentResponseData;

class CancelShipmentRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(
        protected CancelShipmentData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/ship/v1/shipments/cancel';
    }

    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }

    public function createDtoFromResponse(Response $response): CancelShipmentResponseData
    {
        return CancelShipmentResponseData::from($response->json());
    }
}
