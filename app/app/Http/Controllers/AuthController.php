<?php

namespace App\Http\Controllers;

use App\Http\Requests\SingInAuthRequest;
use App\Http\Requests\SingOutAuthRequest;
use App\Http\Requests\SingUpAuthRequest;
use App\Http\Resources\TokenResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Wallet;

class AuthController extends Controller
{
    public function signUp(SingUpAuthRequest $request)
    {
        $user = User::create($request->validated());

        Wallet::create(['currency_id' => $request->input('currency_id'), 'user_id' => $user->id]);

        return [
            'token' => new TokenResource(['access_token' => $user->createToken($user->id)->plainTextToken]),
            'data' => new UserResource($user),
        ];
    }

    public function signIn(SingInAuthRequest $request)
    {
        return [
            'token' => new TokenResource([
                'access_token' => $request->user()->createToken($request->user()->id)->plainTextToken
            ]),
            'data' => new UserResource($request->user()),
        ];
    }

    public function signOut(SingOutAuthRequest $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
