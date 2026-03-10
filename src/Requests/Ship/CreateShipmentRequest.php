<?php

namespace SmartDato\FedEx\Requests\Ship;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SmartDato\FedEx\Data\Ship\CreateShipmentData;
use SmartDato\FedEx\Data\Ship\ShipmentResponseData;

class CreateShipmentRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected CreateShipmentData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/ship/v1/shipments';
    }

    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }

    public function createDtoFromResponse(Response $response): ShipmentResponseData
    {
        return ShipmentResponseData::from($response->json());
    }
}
