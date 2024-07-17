<?php

namespace Obelaw;

use Composer\InstalledVersions;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;
use Obelaw\Compiles\Scan\Modules\InfoCompile;
use Obelaw\Console\CompilingCommand;
use Obelaw\Console\DriverTableCommand;
use Obelaw\Drivers\Abstracts\Driver;
use Obelaw\Drivers\CacheDriver;
use Obelaw\Render\BundlesManagement;
use Obelaw\Render\BundlesScaneers;
use Obelaw\Schema\Scaneer\Scaneer;

class ObelawOEngineServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/engine.php',
            'obelaw.engine'
        );

        $this->app->singleton('obelaw.o.bundles', BundlesManagement::class);

        $this->app->bind(Driver::class, config('obelaw.engine.driver', CacheDriver::class));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootAboutCommand();

            $this->publishes([
                __DIR__ . '/../config/engine.php' => config_path('obelaw/engine.php'),
            ], ['obelaw:engine', 'obelaw:engine:config']);

            $this->commands([
                CompilingCommand::class,
                DriverTableCommand::class,
            ]);
        }

        BundlesScaneers::mergeModuleScaneers(function (Scaneer $scaneers) {
            $scaneers->add(InfoCompile::class, Scaneer::BOOT);
        });
    }

    private function bootAboutCommand()
    {
        if (class_exists(AboutCommand::class) && class_exists(InstalledVersions::class)) {
            AboutCommand::add('Obelaw Environment', [
                'O-Engine Version' => InstalledVersions::getPrettyVersion('obelaw/o-engine'),
            ]);
        }
    }
}
