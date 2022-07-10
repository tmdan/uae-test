<?php

namespace App\Events\Transaction;

use App\Models\Transaction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class TransactionDailyGraphEvent extends TransactionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public function __construct()
    {
       //
    }


    public function broadcastOn(): Channel
    {
        return new Channel('transactions');
    }

    public function broadcastAs()
    {
        return 'graph';
    }

    public function broadcastWith()
    {
        return DB::table('transactions')
            ->select([DB::raw('CONCAT(hour(`created_at`), ":00") as hour'), DB::raw('count(`id`) as count')])
            ->groupBy(Db::raw('CONCAT(hour(`created_at`), ":00")'))
            ->get()->toArray();
    }
}
