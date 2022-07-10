<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'usd_rate_id',
        'type',
        'reason_for_change',
        'value',
        'wallet_id',
        'currency_id',
        'status',
    ];

    public $casts = [
        'value' => 'float',
        'status' => 'string'
    ];


    protected $attributes = [
        'status' => TransactionStatus::IN_PROGRESS
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function usdRate(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UsdRates::class);
    }

    public function walletHistory()
    {
        return $this->hasOne(WalletHistory::class,'transaction_id','id');
    }


}
