<?php

namespace SmartDato\FedEx;

use SmartDato\FedEx\Auth\FedExAuthenticator;
use SmartDato\FedEx\Connectors\DocumentConnector;
use SmartDato\FedEx\Connectors\ShipConnector;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FedExServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('fedex-rest-sdk')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(FedExAuthenticator::class, function () {
            return new FedExAuthenticator(
                clientId: (string) config('fedex-rest-sdk.client_id'),
                clientSecret: (string) config('fedex-rest-sdk.client_secret'),
                baseUrl: (string) config('fedex-rest-sdk.base_url', 'https://apis.fedex.com'),
                grantType: (string) config('fedex-rest-sdk.grant_type', 'client_credentials'),
                childKey: config('fedex-rest-sdk.child_key'),
                childSecret: config('fedex-rest-sdk.child_secret'),
                verifySsl: (bool) config('fedex-rest-sdk.verify_ssl', true),
            );
        });

        $this->app->singleton(ShipConnector::class, function ($app) {
            return new ShipConnector(
                fedExAuthenticator: $app->make(FedExAuthenticator::class),
                verifySsl: (bool) config('fedex-rest-sdk.verify_ssl', true),
            );
        });

        $this->app->singleton(DocumentConnector::class, function ($app) {
            return new DocumentConnector(
                fedExAuthenticator: $app->make(FedExAuthenticator::class),
                verifySsl: (bool) config('fedex-rest-sdk.verify_ssl', true),
            );
        });

        $this->app->singleton(FedEx::class, function ($app) {
            return new FedEx(
                shipConnector: $app->make(ShipConnector::class),
                documentConnector: $app->make(DocumentConnector::class),
            );
        });
    }
}
