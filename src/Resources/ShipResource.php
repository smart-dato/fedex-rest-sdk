<?php

namespace SmartDato\FedEx\Resources;

use Saloon\Http\Request;
use Saloon\Http\Response;
use SmartDato\FedEx\Connectors\ShipConnector;
use SmartDato\FedEx\Data\Ship\AsyncResultsData;
use SmartDato\FedEx\Data\Ship\CancelShipmentData;
use SmartDato\FedEx\Data\Ship\CancelShipmentResponseData;
use SmartDato\FedEx\Data\Ship\CancelTagData;
use SmartDato\FedEx\Data\Ship\CancelTagResponseData;
use SmartDato\FedEx\Data\Ship\CreateShipmentData;
use SmartDato\FedEx\Data\Ship\CreateTagData;
use SmartDato\FedEx\Data\Ship\CreateTagResponseData;
use SmartDato\FedEx\Data\Ship\ShipmentResponseData;
use SmartDato\FedEx\Data\Ship\ValidateShipmentData;
use SmartDato\FedEx\Data\Ship\ValidateShipmentResponseData;
use SmartDato\FedEx\Requests\Ship\CancelShipmentRequest;
use SmartDato\FedEx\Requests\Ship\CancelTagRequest;
use SmartDato\FedEx\Requests\Ship\CreateShipmentRequest;
use SmartDato\FedEx\Requests\Ship\CreateTagRequest;
use SmartDato\FedEx\Requests\Ship\RetrieveAsyncShipRequest;
use SmartDato\FedEx\Requests\Ship\ValidateShipmentRequest;

class ShipResource
{
    protected ?Request $lastRequest = null;

    protected ?Response $lastResponse = null;

    public function __construct(
        protected ShipConnector $connector,
    ) {}

    public function lastRequest(): ?Request
    {
        return $this->lastRequest;
    }

    public function lastResponse(): ?Response
    {
        return $this->lastResponse;
    }

    public function createShipment(CreateShipmentData $data): ShipmentResponseData
    {
        return $this->send(new CreateShipmentRequest($data))->dtoOrFail();
    }

    public function cancelShipment(CancelShipmentData $data): CancelShipmentResponseData
    {
        return $this->send(new CancelShipmentRequest($data))->dtoOrFail();
    }

    public function validateShipment(ValidateShipmentData $data): ValidateShipmentResponseData
    {
        return $this->send(new ValidateShipmentRequest($data))->dtoOrFail();
    }

    public function retrieveAsyncResults(AsyncResultsData $data): ShipmentResponseData
    {
        return $this->send(new RetrieveAsyncShipRequest($data))->dtoOrFail();
    }

    public function createTag(CreateTagData $data): CreateTagResponseData
    {
        return $this->send(new CreateTagRequest($data))->dtoOrFail();
    }

    public function cancelTag(CancelTagData $data, string $shipmentId): CancelTagResponseData
    {
        return $this->send(new CancelTagRequest($data, $shipmentId))->dtoOrFail();
    }

    protected function send(Request $request): Response
    {
        $this->lastRequest = $request;
        $this->lastResponse = $this->connector->send($request);

        return $this->lastResponse;
    }
}
