<?php

namespace App\Services\CurrencyExchange\Contracts;

interface CurrencyExchangeServiceInterface
{
    function response(): object;
    function exchange(string $from, string $to, float $value): float;
}
