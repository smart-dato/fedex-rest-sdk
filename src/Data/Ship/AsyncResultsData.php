<?php

namespace SmartDato\FedEx\Data\Ship;

use Spatie\LaravelData\Data;

class AsyncResultsData extends Data
{
    public function __construct(
        public AccountNumberData $accountNumber,
        public string $jobId,
    ) {}
}
