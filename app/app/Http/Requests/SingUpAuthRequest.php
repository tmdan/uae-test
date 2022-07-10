<?php

namespace App\Http\Requests;

use App\Models\Currency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SingUpAuthRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:2',
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|unique:users',
            'password' => [
                'required',
                'confirmed',
                'max:12',
                Password::min(6)
                    ->letters()
                    ->numbers()
                    ->mixedCase(),
            ],
            'currency' => 'required|exists:currencies,code',
            'currency_id' => 'required|exists:currencies,id',
        ];
    }

    public function messages()
    {
        return [
            'currency.exists' => "Incorrect value currency, available: " . Currency::all()->pluck('code')->implode(', ')
        ];
    }

    public function prepareForValidation()
    {
        $this->validate([
            'currency' => 'required|exists:currencies,code',
        ]);

        $this->merge([
            'currency_id' => Currency::where('code', $this->currency)->first()->id
        ]);
    }

}
