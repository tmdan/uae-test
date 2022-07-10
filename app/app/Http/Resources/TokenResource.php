<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'access_token' => $this['access_token'],
            'type' => 'Bearer',
            'expires_in' => 'unlimited',
        ];
    }
}
