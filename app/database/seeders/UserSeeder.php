<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run()
    {

        Db::table('wallets')->insert([
            'currency_id' => 1,
            'user_id' => Db::table('users')->insertGetId([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin@admin.com'),
            ])
        ]);

        Db::table('wallets')->insert([
            'currency_id' => 2,
            'user_id' => Db::table('users')->insertGetId([
                'name' => 'sam',
                'email' => 'sam@moderator.com',
                'email_verified_at' => now(),
                'password' => Hash::make('moderator@moderator.com'),
            ])
        ]);

        Db::table('wallets')->insert([
            'currency_id' => 1,
            'user_id' => Db::table('users')->insertGetId([
                'name' => 'bill',
                'email' => 'bill@moderator.com',
                'email_verified_at' => now(),
                'password' => Hash::make('bill@moderator.com'),
            ])
        ]);

    }
}
