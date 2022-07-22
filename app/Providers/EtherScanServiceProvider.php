<?php

namespace App\Providers;

use App\Services\EtherScan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class EtherScanServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(EtherScan::class, function (Application $app) {
            return new EtherScan(config('services.etherscan.host'), config('services.etherscan.key'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function provides()
    {
        return [
            EtherScan::class
        ];
    }
}
