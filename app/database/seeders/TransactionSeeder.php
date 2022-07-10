<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{

    public function run()
    {
        Db::table('transactions')->insertOrIgnore([
            [
                'type' => "debit",
                'reason_for_change' => "stock",
                'value' => 2.75,
                'wallet_id' => 1,
                'currency_id' => 1,
                'usd_rate_id' => 1,
            ]
        ]);
    }
}
