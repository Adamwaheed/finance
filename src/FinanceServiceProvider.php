<?php

namespace Atolon\Finance;

use Atolon\Finance\Commands\Finance;
use Illuminate\Support\ServiceProvider;

class FinanceServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');

        require __DIR__.'/Jobs/GiveSequence.php';

        if ($this->app->runningInConsole()) {
            $this->commands([
                Finance::class,
            ]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->publishes([
            __DIR__.'/config.php' => config_path('finance.php'),
        ]);

        $this->publishes([
            __DIR__ . '/Blueprints/SequenceSeeder.bp' => database_path('/seeds/SequenceSeeder.php'),
        ]);


        $this->app->singleton('finance', function ($app) {
            return new \Atolon\Finance\Finance();
        });

    }
}
