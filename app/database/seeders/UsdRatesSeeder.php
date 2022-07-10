<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsdRatesSeeder extends Seeder
{

    public function run()
    {
        Db::table('usd_rates')->insertOrIgnore([
            [
                'currency_id' => Currency::where('code', 'USD')->first()->id,
                'value' => 1,
            ],
            [
                'currency_id' => Currency::where('code', 'RUB')->first()->id,
                'value' => 58.4,
            ],
        ]);
    }
}
