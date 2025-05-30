<?php

namespace MerakiShop\Helpers;

use Illuminate\Support\Facades\Log;

class Logger
{
    private $divider = PHP_EOL . "==============================================" . PHP_EOL;

    public function critical(string $msg, array $context = [], string $code = "UNKNOWN")
    {
        Log::critical("$code | $msg" . PHP_EOL, [...$context, $this->divider]);
    }

    public function error(string $msg, array $context = [], string $code = "UNKNOWN")
    {
        Log::error("$code | $msg" . PHP_EOL, [...$context, $this->divider]);
    }
}
