# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Laravel package (`smart-dato/fedex-rest-sdk`) providing a PHP SDK for the FedEx REST API. Built with Saloon v3 for HTTP, Spatie Laravel Data for DTOs, and Spatie Laravel Package Tools for the service provider. Requires PHP 8.4+, supports Laravel 11 and 12.

Namespace: `SmartDato\FedEx\`

## Commands

```bash
composer test                          # Run Pest test suite
composer test -- --filter=TestName     # Run a single test
composer format                        # Fix code style with Laravel Pint
composer analyse                       # Run PHPStan static analysis (level 5)
composer test-coverage                 # Run tests with coverage
```

## Architecture

Follows the same layered pattern as `smart-dato/correos-shipping-sdk`:

```
Facade → FedEx (main class) → Resources → Requests → Connectors → FedEx API
                                  ↕            ↕
                                DTOs        Auth
```

### Key layers

- **`FedEx`** — Main service class with `make(array $config)` factory for on-the-fly instantiation. Lazy-loads resources via `ship()` and `documents()`.
- **Connectors** (`src/Connectors/`) — `FedExConnector` (abstract base), `ShipConnector` (apis.fedex.com), `DocumentConnector` (documentapi.prod.fedex.com). Handle auth injection, SSL, error handling.
- **Resources** (`src/Resources/`) — `ShipResource` and `DocumentResource`. Each method creates a Request, sends via connector, returns a DTO. Expose `lastRequest()` and `lastResponse()` for debugging.
- **Requests** (`src/Requests/Ship/`, `src/Requests/Document/`) — One class per API endpoint. Ship requests use `HasJsonBody`, Document requests use `HasMultipartBody`. Each has `createDtoFromResponse()`.
- **DTOs** (`src/Data/Ship/`, `src/Data/Document/`) — Spatie Laravel Data classes. Request DTOs use `Optional` for optional fields; response DTOs use nullable (`?`) types.
- **Auth** (`src/Auth/FedExAuthenticator.php`) — OAuth2 client_credentials flow with Laravel Cache (55 min TTL). Supports 3 grant types: `client_credentials`, `csp_credentials`, `client_pc_credentials`.
- **Enums** (`src/Enums/`) — String-backed enums for API constants.
- **Exception** (`src/Exceptions/FedExApiException.php`) — Parses `errorCode` and `transactionId` from API error responses.

### API Coverage

- **Ship API** (6 endpoints): createShipment, cancelShipment, validateShipment, retrieveAsyncResults, createTag, cancelTag
- **Document API** (4 endpoints): uploadDocument, uploadImage, multiUploadDocuments, encodedMultiUploadDocuments

### Usage patterns

```php
// Via Laravel Facade:
FedEx::ship()->createShipment($data);

// On the fly:
$fedex = FedEx::make(['client_id' => '...', 'client_secret' => '...']);
$fedex->ship()->createShipment($data);

// Access raw request/response:
$fedex->ship()->lastRequest();
$fedex->ship()->lastResponse();
```

## Testing

- **Pest v4** with Laravel and Architecture plugins
- Base class: `tests/TestCase.php` (Orchestra Testbench, registers `LaravelDataServiceProvider`)
- Mock HTTP with Saloon's `MockClient` + `MockResponse`, map to specific Request classes
- Fixtures in `tests/Fixtures/` (JSON request/response examples)
- Cache a fake OAuth token in `beforeEach` to avoid real auth calls
- Architecture test ensures no `dd`, `dump`, `ray` in source

## Code Style & Static Analysis

- **Laravel Pint** for formatting
- **PHPStan/Larastan** at level 5; `larastan.noEnvCallsOutsideOfConfig` ignored for package config file

## API Documentation

OpenAPI specs in `docs/`: `authorization.json`, `ship.json`, `upload-documents.json`. Postman collection with 1,335 test cases in `docs/Ship APIResponse JSONApiCollection/`.
