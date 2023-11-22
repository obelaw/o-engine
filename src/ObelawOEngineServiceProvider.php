<?php

namespace Obelaw;

use Illuminate\Support\ServiceProvider;
use Obelaw\Compiles\CompileManagement;
use Obelaw\Console\CompilingCommand;
use Obelaw\Drivers\Abstracts\Driver;
use Obelaw\Drivers\CacheDriver;

class ObelawOEngineServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('obelaw.o.compile', CompileManagement::class);

        $this->app->bind(Driver::class, CacheDriver::class);
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
