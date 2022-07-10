<?php

namespace App\Events\Transaction;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class TransactionEvent  implements ShouldBroadcast
{
    public function broadcastOn(): Channel
    {
        return new Channel('transactions');
    }

    public function broadcastAs()
    {
        return 'events';
    }

    public function broadcastWith()
    {
        return [
            'transaction' => [
                'id' => $this->transaction->id,
                'type' => $this->transaction->type,
                'reason' => $this->transaction->reason_for_change,
                'value' => $this->transaction->value,
                'status' => $this->transaction->status,
                'created_at' => $this->transaction->created_at->format("Y-m-d h:m:s"),
                'currency' => $this->transaction->currency->code,
            ],

            'recipient' => [
                'email' => $this->transaction->wallet->user->email,
                'name' => $this->transaction->wallet->user->name,
            ],

            'recipient_wallet' => [
                'id' => $this->transaction->wallet->id,
                'value' => $this->transaction->wallet->value,
                'currency' => $this->transaction->wallet->currency->code,
            ]

        ];
    }
}
