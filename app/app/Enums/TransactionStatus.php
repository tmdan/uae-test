<?php

namespace App\Enums;

use ReflectionClass;

class TransactionStatus
{
    const SUCCESS = 'success';
    const IN_PROGRESS = 'in progress';
    const DENIED = 'denied';

    public  static function allValues(): array
    {
        return array_values((new ReflectionClass(__CLASS__))->getConstants());
    }

    public static function random()
    {
        return TransactionStatus::allValues()[array_rand(TransactionStatus::allValues(), 1)];
    }

}
