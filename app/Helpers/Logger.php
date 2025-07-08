<?php

namespace MerakiShop\Helpers;

use Illuminate\Support\Facades\Log;

class Logger
{
    private $divider = PHP_EOL.'=============================================='.PHP_EOL;

    public function info(string $msg, array $context = [], string $code = 'UNKNOWN'): void
    {
        Log::info("$code | $msg".PHP_EOL, [...$context, $this->divider]);
    }

    public function critical(string $msg, array $context = [], string $code = 'UNKNOWN'): void
    {
        Log::critical("$code | $msg".PHP_EOL, [...$context, $this->divider]);
    }

    public function error(string $msg, array $context = [], string $code = 'UNKNOWN'): void
    {
        Log::error("$code | $msg".PHP_EOL, [...$context, $this->divider]);
    }

    public function debug(string $msg, array $context = [], string $code = 'UNKNOWN'): void
    {
        Log::debug("$code | $msg".PHP_EOL, [...$context, $this->divider]);
    }
}
