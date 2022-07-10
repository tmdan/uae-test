<?php

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\TransactionController;
use App\Services\CurrencyExchange\CurrencyExchangeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::get('tess', function (CurrencyExchangeService $currencyExchangeService) {


    dd($currencyExchangeService->exchange('RUB', 'USD', 59));
});

/**
 * Everything related to registration and authorization of users
 */
Route::group([
    'prefix' => 'auth',
], function () {

    //registration and authorization using login and password
    Route::post('sign-up', [AuthController::class, 'signUp'])->name('api.sign-up');

    //login to the application
    Route::post('sign-in', [AuthController::class, 'signIn'])->name('api.sign-in');

    //Sign out from app
    Route::post('sign-out', [AuthController::class, 'signOut'])->name('api.sign-out')->middleware(['auth:sanctum']);

});


Route::resource('currencies', CurrencyController::class)
    ->only(['index']);

Route::resource('transactions', TransactionController::class)
    ->only(['store', 'index']);

Route::get('transactions/graph', [TransactionController::class, 'dailyGraph']);
Route::post('transactions/autotest', [TransactionController::class, 'autotest']);
