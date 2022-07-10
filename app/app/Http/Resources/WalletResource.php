<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'value' => $this->value,
            'currency' => $this->currency->code,
        ];
    }
}
