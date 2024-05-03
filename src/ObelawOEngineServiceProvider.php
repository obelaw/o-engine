<?php

namespace Obelaw;

use Composer\InstalledVersions;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;
use Obelaw\Compiles\CompileManagement;
use Obelaw\Compiles\Scan\Appends\NavbarAppendsCompile;
use Obelaw\Compiles\Scan\Appends\ViewsAppendsCompile;
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
        BundlesScaneers::mergeModuleScaneers(function (Scaneer $scaneers) {
            $scaneers->add(InfoCompile::class, Scaneer::BOOT);
            $scaneers->add(NavbarCompile::class);
            $scaneers->add(RoutesDashboardCompile::class);
            $scaneers->add(RoutesApiCompile::class);
            $scaneers->add(FormsCompile::class);
            $scaneers->add(GridsCompile::class);
            $scaneers->add(ViewsCompile::class);
            $scaneers->add(WidgetsCompile::class);
            $scaneers->add(MigrationsCompile::class);
            $scaneers->add(SeedsCompile::class);
            $scaneers->add(SeedsCompile::class);
        });

        BundlesScaneers::mergePluginScaneers(function (Scaneer $scaneers) {
            $scaneers->add(NavbarPluginCompile::class);
            $scaneers->add(RoutesDashboardPluginCompile::class);
            $scaneers->add(RoutesApiPluginCompile::class);
            $scaneers->add(FormsPluginCompile::class);
            $scaneers->add(GridsPluginCompile::class);
            $scaneers->add(ViewsPluginCompile::class);
            $scaneers->add(MigrationsPluginCompile::class);
        });

        BundlesScaneers::mergeAppendScaneers(function (Scaneer $scaneers) {
            $scaneers->add(NavbarAppendsCompile::class);
            $scaneers->add(ViewsAppendsCompile::class);
        });

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
