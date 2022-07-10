<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(CurrencySeeder::class);
        $this->call(WalletSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UsdRatesSeeder::class);
        $this->call(TransactionSeeder::class);
    }
}
