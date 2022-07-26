<?php

namespace App\Providers;

use App\Services\PolygonScan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PolygonScanServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PolygonScan::class, function (Application $app) {
            return new PolygonScan(config('services.polygonscan.host'), config('services.polygonscan.key'));
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
            PolygonScan::class,
        ];
    }
}
