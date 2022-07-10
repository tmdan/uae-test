<?php

namespace App\Events\Transaction;

use App\Models\Transaction;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionDeniedEvent extends TransactionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Transaction $transaction;


    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }
}
