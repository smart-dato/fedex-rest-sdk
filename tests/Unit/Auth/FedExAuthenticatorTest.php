<?php

use SmartDato\FedEx\Auth\FedExAuthenticator;

it('is a saloon authenticator', function () {
    $authenticator = new FedExAuthenticator(
        clientId: 'test-client-id',
        clientSecret: 'test-client-secret',
        baseUrl: 'https://apis-sandbox.fedex.com',
    );

    expect($authenticator)->toBeInstanceOf(\Saloon\Contracts\Authenticator::class);
});

it('supports different grant types', function () {
    $authenticator = new FedExAuthenticator(
        clientId: 'test-client-id',
        clientSecret: 'test-client-secret',
        baseUrl: 'https://apis-sandbox.fedex.com',
        grantType: 'csp_credentials',
        childKey: 'child-key',
        childSecret: 'child-secret',
    );

    expect($authenticator)->toBeInstanceOf(\Saloon\Contracts\Authenticator::class);
});
