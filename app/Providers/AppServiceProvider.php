<?php

namespace MerakiShop\Providers;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Scramble::configure()
        ->withDocumentTransformers(function (OpenApi $openApi) {
            /** @var SecurityScheme $scheme */
            $scheme = SecurityScheme::http('bearer');

            $openApi->secure($scheme);
        });
    }
}
