<?php

namespace SmartDato\FedEx\Requests\Ship;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SmartDato\FedEx\Data\Ship\CreateTagData;
use SmartDato\FedEx\Data\Ship\CreateTagResponseData;

class CreateTagRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected CreateTagData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/ship/v1/shipments/tag';
    }

    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }

    public function createDtoFromResponse(Response $response): CreateTagResponseData
    {
        return CreateTagResponseData::from($response->json());
    }
}
