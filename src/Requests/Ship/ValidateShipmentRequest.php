<?php

namespace SmartDato\FedEx\Requests\Ship;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SmartDato\FedEx\Data\Ship\ValidateShipmentData;
use SmartDato\FedEx\Data\Ship\ValidateShipmentResponseData;

class ValidateShipmentRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected ValidateShipmentData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/ship/v1/shipments/packages/validate';
    }

    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }

    public function createDtoFromResponse(Response $response): ValidateShipmentResponseData
    {
        return ValidateShipmentResponseData::from($response->json());
    }
}
