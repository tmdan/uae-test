<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('currencies')->insertOrIgnore([
            [
                'code' => "USD"
            ],
            [
                'code' => "RUB"
            ],
        ]);
    }
}
