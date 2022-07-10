<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'transaction' => [
                'id' => $this->id,
                'type' => $this->type,
                'reason' => $this->reason_for_change,
                'value' => $this->value,
                'status' => $this->status,
                'currency' => $this->currency->code,
                'created_at' => $this->created_at->format("Y-m-d h:m:s"),
            ],
            'recipient' => [
                'email' => $this->wallet->user->email,
                'name' => $this->wallet->user->name,
            ],
            'recipient_wallet' => [
                'id' => $this->wallet->id,
                'value' => $this->wallet->value,
                'currency' => $this->wallet->currency->code,
            ],
        ];
    }
}
