<?php

namespace App\Enums;

use ReflectionClass;

class TransactionReason
{
    const STOCK = 'stock';
    const REFUND = 'refund';


    public  static function allValues(): array
    {
        return array_values((new ReflectionClass(__CLASS__))->getConstants());
    }

    public static function random()
    {
        return TransactionReason::allValues()[array_rand(TransactionReason::allValues(), 1)];
    }
}
