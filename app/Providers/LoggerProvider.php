<?php

namespace MerakiShop\Providers;

use Illuminate\Support\ServiceProvider;
use MerakiShop\Helpers\Logger;

class LoggerProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('Logger', fn() => new Logger);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
