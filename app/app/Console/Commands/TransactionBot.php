<?php

namespace App\Console\Commands;

use App\Enums\TransactionReason;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Events\Transaction\TransactionInProgressEvent;
use App\Models\Transaction;
use App\Models\UsdRates;
use App\Models\Wallet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TransactionBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:bot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        foreach(range(0, 100) as $item) {

            $transaction = Transaction::create([
                'usd_rate_id' => Db::table('usd_rates')->latest()->first()->id,
                'type' => TransactionType::random(),
                'reason_for_change' => TransactionReason::random(),
                'value' => rand(1, 100),
                'wallet_id' => Db::table('wallets')->inRandomOrder()->first()->id,
                'currency_id' => DB::table('currencies')->inRandomOrder()->first()->id,
            ]);

            event(new TransactionInProgressEvent($transaction));

        }




        return 0;
    }
}
