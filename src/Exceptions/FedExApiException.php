<?php

namespace SmartDato\FedEx\Exceptions;

use Exception;
use Saloon\Http\Response;

class FedExApiException extends Exception
{
    public function __construct(
        string $message,
        int $code = 0,
        public readonly ?string $errorCode = null,
        public readonly ?string $transactionId = null,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function fromResponse(Response $response): self
    {
        try {
            $data = $response->json();
        } catch (\JsonException) {
            $data = [];
        }

        $error = $data['errors'][0] ?? [];

        return new self(
            message: $error['message'] ?? $response->body(),
            code: $response->status(),
            errorCode: $error['code'] ?? null,
            transactionId: $data['transactionId'] ?? null,
        );
    }
}
