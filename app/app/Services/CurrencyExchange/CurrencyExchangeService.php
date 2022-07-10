<?php

namespace App\Services\CurrencyExchange;

use App\Services\CurrencyExchange\Contracts\CurrencyExchangeServiceInterface;
use Illuminate\Support\Facades\Http;

class CurrencyExchangeService implements CurrencyExchangeServiceInterface
{
    private $data;

    public function response(): object
    {
        return $data ??= Http::get(config('services.currency_exchange.url'))->object();
    }


    public function exchange(string $from, string $to, float $value) : float
    {
        return $this->response()->rates->{$to}/$this->response()->rates->{$from} * $value;
    }

}
