<?php

namespace SmartDato\FedEx\Auth;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Saloon\Contracts\Authenticator;
use Saloon\Http\PendingRequest;

class FedExAuthenticator implements Authenticator
{
    public function __construct(
        protected string $clientId,
        protected string $clientSecret,
        protected string $baseUrl,
        protected string $grantType = 'client_credentials',
        protected ?string $childKey = null,
        protected ?string $childSecret = null,
        protected bool $verifySsl = true,
    ) {}

    public function set(PendingRequest $pendingRequest): void
    {
        $pendingRequest->headers()->add('Authorization', 'Bearer '.$this->getToken());
    }

    protected function getToken(): string
    {
        $cacheKey = 'fedex_oauth_token_'.md5($this->clientId.$this->grantType.($this->childKey ?? ''));

        return Cache::remember($cacheKey, 3300, fn () => $this->fetchToken());
    }

    protected function fetchToken(): string
    {
        $payload = [
            'grant_type' => $this->grantType,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ];

        if ($this->childKey && $this->childSecret) {
            $payload['child_Key'] = $this->childKey;
            $payload['child_secret'] = $this->childSecret;
        }

        $response = Http::asForm()
            ->withOptions(['verify' => $this->verifySsl])
            ->post($this->baseUrl.'/oauth/token', $payload);

        $response->throw();

        return $response->json('access_token');
    }
}
