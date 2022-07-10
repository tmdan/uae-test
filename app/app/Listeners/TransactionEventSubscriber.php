<?php

namespace App\Listeners;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Events\Transaction\TransactionDailyGraphEvent;
use App\Events\Transaction\TransactionEvent;
use App\Events\Transaction\TransactionInProgressEvent;
use App\Events\Transaction\TransactionSuccessEvent;
use App\Models\UsdRates;
use App\Models\WalletHistory;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;


class TransactionEventSubscriber implements ShouldQueue
{

    public function handleInProgress(TransactionInProgressEvent $event)
    {

        try {

            switch ($event->transaction->type) {
                case TransactionType::DEBIT:
                    {
                        //текущее значение
                        $currentValue = $event->transaction->wallet->value;

                        //значение на которое измениться
                        $changeValue = UsdRates::where('currency_id', $event->transaction->wallet->currency_id)->first()->value /
                            UsdRates::where('currency_id', $event->transaction->currency_id)->first()->value *
                            $event->transaction->value;

                        //новое значение
                        $newValue = $currentValue + $changeValue;

                        //изменяем значение кошелька
                        $event->transaction->wallet()->update(['value' => $newValue]);

                        //Запишем историю
                        WalletHistory::create([
                            'was' => $currentValue,
                            'become' => $newValue,
                            'transaction_id' => $event->transaction->id,
                            'wallet_id' => $event->transaction->wallet->id,
                        ]);
                    }
                    break;

                case TransactionType::CREDIT:
                    {

                        //текущее значение
                        $currentValue = $event->transaction->wallet->value;

                        //значение на которое измениться
                        $changeValue = UsdRates::where('currency_id', $event->transaction->wallet->currency_id)->first()->value /
                            UsdRates::where('currency_id', $event->transaction->currency_id)->first()->value *
                            $event->transaction->value;

                        //новое значение
                        $newValue = $currentValue - $changeValue;

                        //изменяем значение кошелька
                        $event->transaction->wallet()->update(['value' => $newValue]);


                    }
                    break;
            };

            $event->transaction->update(['status' => TransactionStatus::SUCCESS]);

            event(new TransactionSuccessEvent($event->transaction));

        } catch (Exception $exception) {

            $event->transaction->update(['status' => TransactionStatus::DENIED]);

            event(new TransactionEvent($event->transaction));

            throw $exception;
        }

    }


    public function handleSuccess()
    {
        event(new TransactionDailyGraphEvent);
    }

    public function handleFail()
    {
        //
    }


    public function handleDailyGraph()
    {
        //
    }


    public function subscribe($events)
    {
        $events->listen(
            TransactionInProgressEvent::class,
            [TransactionEventSubscriber::class, 'handleInProgress']
        );

        $events->listen(
            TransactionSuccessEvent::class,
            [TransactionEventSubscriber::class, 'handleSuccess']
        );

        $events->listen(
            TransactionEvent::class,
            [TransactionEventSubscriber::class, 'handleFail']
        );

        $events->listen(
            TransactionDailyGraphEvent::class,
            [TransactionEventSubscriber::class, 'handleDailyGraph']
        );
    }
}
