<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletSeeder extends Seeder
{

    public function run()
    {
        Db::table('wallets')->insertOrIgnore([
            [
                'value' => 10.25,
                'currency_id' => 1,
                'user_id' => 1
            ],
            [
                'value' => 40.14,
                'currency_id' => 2,
                'user_id' => 1
            ],
        ]);
    }
}
