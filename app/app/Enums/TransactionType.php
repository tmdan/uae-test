<?php

namespace App\Enums;

use ReflectionClass;

class TransactionType
{
    const DEBIT = 'debit';
    const CREDIT = 'credit';

    public static function allValues(): array
    {
        return array_values((new ReflectionClass(__CLASS__))->getConstants());
    }

    public static function random()
    {
        return TransactionType::allValues()[array_rand(TransactionType::allValues(), 1)];
    }


}
