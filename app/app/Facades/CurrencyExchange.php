<?php

namespace App\Facades;

use App\Services\CurrencyExchange\CurrencyExchangeService;
use Illuminate\Support\Facades\Facade;

class CurrencyExchange extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CurrencyExchangeService::class;
    }
}
