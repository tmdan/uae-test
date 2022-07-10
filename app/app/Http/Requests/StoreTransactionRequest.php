<?php

namespace App\Http\Requests;

use App\Enums\TransactionReason;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Models\Currency;
use App\Models\UsdRates;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\In;

class StoreTransactionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'type' => [
                'required',
                new In(

                    TransactionType::allValues()
                )
            ],
            'reason' => [
                'required',
                new In(

                    TransactionReason::allValues()

                )
            ],
            'value' => 'required|numeric',
            'currency_id' => 'required|exists:currencies,id',
            'wallet_id' => 'required|exists:wallets,id',
            'currency' => 'required|exists:currencies,code',
            'usd_rate_id' => 'required|exists:usd_rates,id',
        ];
    }


    protected function prepareForValidation()
    {
        $this->validate([
            'email' => 'required|exists:users,email',
        ]);


        $currencyId = Currency::where('code', $this->currency)->first()->id;

        $walletId = User::where('email', $this->email)->first()->wallet->id;


        $this->merge([
            'currency_id' => Currency::where('code', $this->currency)->first()->id,
            'usd_rate_id' => UsdRates::where('currency_id', $currencyId)->latest()->first()->id,
            'wallet_id' => $walletId
        ]);
    }

    public function messages()
    {
        return [
            'currency.exists' => "Incorrect value currency, available: " . Currency::all()->pluck('code')->implode(', ')
        ];
    }

}
