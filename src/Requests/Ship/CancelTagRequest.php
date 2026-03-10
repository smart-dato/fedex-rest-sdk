<?php

namespace SmartDato\FedEx\Requests\Ship;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SmartDato\FedEx\Data\Ship\CancelTagData;
use SmartDato\FedEx\Data\Ship\CancelTagResponseData;

class CancelTagRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(
        protected CancelTagData $data,
        protected string $shipmentId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/ship/v1/shipments/tag/cancel/{$this->shipmentId}";
    }

    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }

    public function createDtoFromResponse(Response $response): CancelTagResponseData
    {
        return CancelTagResponseData::from($response->json());
    }
}
