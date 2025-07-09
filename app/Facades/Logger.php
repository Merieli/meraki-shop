<?php

namespace MerakiShop\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void info(string $message, array<mixed,mixed> $context = [], string $code = 'UNKNOWN')
 * @method static void critical(string $message, array<mixed,mixed> $context = [], string $code = 'UNKNOWN')
 * @method static void error(string $message, array<mixed,mixed> $context = [], string $code = 'UNKNOWN')
 * @method static void debug(string $message, array<mixed,mixed> $context = [], string $code = 'UNKNOWN')
 */
class Logger extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'Logger';
    }
}
