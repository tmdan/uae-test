<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    const CODES = [
        "AUD",
        "AZN",
        "GBP",
        "AMD",
        "BYN",
        "BGN",
        "BRL",
        "HUF",
        "HKD",
        "DKK",
        "USD",
        "EUR",
        "INR",
        "KZT",
        "CAD",
        "KGS",
        "CNY",
        "MDL",
        "NOK",
        "PLN",
        "RON",
        "XDR",
        "SGD",
        "TJS",
        "TRY",
        "TMT",
        "UZS",
        "UAH",
        "CZK",
        "SEK",
        "CHF",
        "ZAR",
        "KRW",
        "JPY",
        "RUB",
    ];

    protected $fillable = [
        'code'
    ];
}
