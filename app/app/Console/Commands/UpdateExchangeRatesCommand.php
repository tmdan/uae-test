<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\UsdRates;
use App\Services\CurrencyExchange\CurrencyExchangeService;
use Illuminate\Console\Command;

class UpdateExchangeRatesCommand extends Command
{
    protected $signature = 'exchange-rates:update';

    protected $description = 'Update exchange rates for exists currents';

    public CurrencyExchangeService $currencyExchangeService;

    /**
     * @param CurrencyExchangeService $currencyExchangeService
     */
    public function __construct(CurrencyExchangeService $currencyExchangeService)
    {
        $this->currencyExchangeService = $currencyExchangeService;

        parent::__construct();
    }

    public function handle()
    {

        foreach (Currency::all() as $currency) {

            UsdRates::updateOrCreate([
                'currency_id' => $currency->id,
                'value' => number_format($this->currencyExchangeService->exchange("USD", $currency->code, 1),2)
            ]);
        }

        return 0;
    }
}
