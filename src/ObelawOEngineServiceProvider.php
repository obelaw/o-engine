<?php

namespace Obelaw;

use Composer\InstalledVersions;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;
use Obelaw\Compiles\CompileManagement;
use Obelaw\Compiles\Scan\Modules\ACLCompile;
use Obelaw\Compiles\Scan\Modules\FormsCompile;
use Obelaw\Compiles\Scan\Modules\GridsCompile;
use Obelaw\Compiles\Scan\Modules\InfoCompile;
use Obelaw\Compiles\Scan\Modules\MigrationsCompile;
use Obelaw\Compiles\Scan\Modules\NavbarCompile;
use Obelaw\Compiles\Scan\Modules\RoutesApiCompile;
use Obelaw\Compiles\Scan\Modules\RoutesDashboardCompile;
use Obelaw\Compiles\Scan\Modules\SeedsCompile;
use Obelaw\Compiles\Scan\Modules\ViewsCompile;
use Obelaw\Compiles\Scan\Modules\WidgetsCompile;
use Obelaw\Compiles\Scan\Plugins\ACLPluginCompile;
use Obelaw\Compiles\Scan\Plugins\FormsPluginCompile;
use Obelaw\Compiles\Scan\Plugins\GridsPluginCompile;
use Obelaw\Compiles\Scan\Plugins\MigrationsPluginCompile;
use Obelaw\Compiles\Scan\Plugins\NavbarPluginCompile;
use Obelaw\Compiles\Scan\Plugins\RoutesApiPluginCompile;
use Obelaw\Compiles\Scan\Plugins\RoutesDashboardPluginCompile;
use Obelaw\Compiles\Scan\Plugins\ViewsPluginCompile;
use Obelaw\Console\CompilingCommand;
use Obelaw\Console\DriverTableCommand;
use Obelaw\Drivers\Abstracts\Driver;
use Obelaw\Drivers\CacheDriver;
use Obelaw\Facades\Compile;
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
        $this->mergeConfigFrom(
            __DIR__ . '/../config/engine.php',
            'obelaw.engine'
        );

        $this->app->singleton('obelaw.o.compile', CompileManagement::class);
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
        Compile::mergeModuleScaneers([
            InfoCompile::class,
            ACLCompile::class,
            NavbarCompile::class,
            RoutesDashboardCompile::class,
            RoutesApiCompile::class,
            FormsCompile::class,
            GridsCompile::class,
            ViewsCompile::class,
            WidgetsCompile::class,
            MigrationsCompile::class,
            SeedsCompile::class,
        ]);

        Compile::mergePluginScaneers([
            NavbarPluginCompile::class,
            RoutesDashboardPluginCompile::class,
            RoutesApiPluginCompile::class,
            FormsPluginCompile::class,
            GridsPluginCompile::class,
            ViewsPluginCompile::class,
            ACLPluginCompile::class,
            MigrationsPluginCompile::class,
        ]);

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
