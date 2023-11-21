<?php

namespace Obelaw;

use Illuminate\Support\ServiceProvider;
use Obelaw\Console\CompilingCommand;

class ObelawOEngineServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CompilingCommand::class,
            ]);
        }
    }
}
