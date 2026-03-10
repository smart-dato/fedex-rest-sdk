<?php

namespace SmartDato\FedEx\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SmartDato\FedEx\FedEx
 */
class FedEx extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \SmartDato\FedEx\FedEx::class;
    }
}
