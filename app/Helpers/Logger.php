<?php

namespace MerakiShop\Helpers;

use Illuminate\Support\Facades\Log;

class Logger
{
    private string $divider = PHP_EOL.'=============================================='.PHP_EOL;

    /**
     * @param string $msg
     * @param array<string> $context
     * @param string $code
     * @return void
     */
    public function info(string $msg, array $context = [], string $code = 'UNKNOWN'): void
    {
        Log::info("$code | $msg".PHP_EOL, [...$context, $this->divider]);
    }

    /**
     * @param string $msg
     * @param array<string> $context
     * @param string $code
     * @return void
     */
    public function critical(string $msg, array $context = [], string $code = 'UNKNOWN'): void
    {
        Log::critical("$code | $msg".PHP_EOL, [...$context, $this->divider]);
    }

    /**
     * @param string $msg
     * @param array<string> $context
     * @param string $code
     * @return void
     */
    public function error(string $msg, array $context = [], string $code = 'UNKNOWN'): void
    {
        Log::error("$code | $msg".PHP_EOL, [...$context, $this->divider]);
    }

    /**
     * @param string $msg
     * @param array<string> $context
     * @param string $code
     * @return void
     */
    public function debug(string $msg, array $context = [], string $code = 'UNKNOWN'): void
    {
        Log::debug("$code | $msg".PHP_EOL, [...$context, $this->divider]);
    }
}
