<?php

namespace App\Http\Controllers;


use App\Events\Transaction\TransactionInProgressEvent;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;


class TransactionController extends Controller
{

    public function index(Request $request)
    {
        return TransactionResource::collection(Transaction::latest()->limit(10)->get());
    }

    public function store(StoreTransactionRequest $request)
    {
        $transaction = Transaction::create($request->validated());

        event(new TransactionInProgressEvent($transaction));

        return (new TransactionResource($transaction))
            ->additional(['message' => 'Your transaction has been queued']);
    }


    public function show(Transaction $transaction)
    {
        //
    }

    public function dailyGraph()
    {
        //select  CONCAT(hour(`created_at`), ":00")   as hour, count(`id`) as count
        //from transactions
        //group by CONCAT(hour(`created_at`), ":00");

        return DB::table('transactions')
            ->select([DB::raw('CONCAT(hour(`created_at`), ":00") as hour'), DB::raw('count(`id`) as count')])
            ->groupBy(Db::raw('CONCAT(hour(`created_at`), ":00")'))
            ->get();
    }


    public function autotest()
    {
        Artisan::call('transaction:bot');
    }
}
