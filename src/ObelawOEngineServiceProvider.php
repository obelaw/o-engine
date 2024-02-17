<?php

namespace Obelaw;

use Illuminate\Support\ServiceProvider;
use Obelaw\Compiles\CompileManagement;
use Obelaw\Console\CompilingCommand;
use Obelaw\Drivers\Abstracts\Driver;
use Obelaw\Drivers\CacheDriver;
use Obelaw\Render\BundlesManagement;

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
        $this->app->singleton('obelaw.o.bundles', BundlesManagement::class);

        $this->app->bind(Driver::class, CacheDriver::class);

        $this->mergeConfigFrom(
            __DIR__ . '/../config/engine.php',
            'obelaw.engine'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/engine.php' => config_path('obelaw/engine.php'),
            ], ['obelaw:engine', 'obelaw:engine:config']);

            $this->commands([
                CompilingCommand::class,
            ]);
        }
    }
}
