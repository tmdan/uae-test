<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SingInAuthRequest extends FormRequest
{
    private User $user;

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }


    public function user($guard = null)
    {
        try {

            return $this->user ??= User::where('email', $this->email)->firstOrFail();

        } catch (ModelNotFoundException $e) {

            throw ValidationException::withMessages([
                'email' => "Wrong email or password",
            ]);
        }
    }


    public function passedValidation()
    {
        if (!Hash::check($this->password, $this->user()->password))
            throw ValidationException::withMessages([
                'email' => "Wrong email or password",
            ]);
    }
}
