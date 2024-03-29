<?php

namespace Obelaw\Compiles;

use Obelaw\Compiles\ACLCompile;
use Obelaw\Compiles\Appends\NavbarAppendsCompile;
use Obelaw\Compiles\Appends\ViewsAppendsCompile;
use Obelaw\Compiles\FormsCompile;
use Obelaw\Compiles\GridsCompile;
use Obelaw\Compiles\InfoCompile;
use Obelaw\Compiles\MigrationsCompile;
use Obelaw\Compiles\NavbarCompile;
use Obelaw\Compiles\Plugins\ACLPluginCompile;
use Obelaw\Compiles\Plugins\FormsPluginCompile;
use Obelaw\Compiles\Plugins\GridsPluginCompile;
use Obelaw\Compiles\Plugins\MigrationsPluginCompile;
use Obelaw\Compiles\Plugins\NavbarPluginCompile;
use Obelaw\Compiles\Plugins\RoutesApiPluginCompile;
use Obelaw\Compiles\Plugins\RoutesDashboardPluginCompile;
use Obelaw\Compiles\Plugins\ViewsPluginCompile;
use Obelaw\Compiles\RoutesApiCompile;
use Obelaw\Compiles\RoutesDashboardCompile;
use Obelaw\Compiles\SeedsCompile;
use Obelaw\Compiles\ViewsCompile;
use Obelaw\Compiles\WidgetsCompile;
use Obelaw\Drivers\Abstracts\Driver;
use Obelaw\Render\ExternalDirectory;
use Obelaw\Schema\BundleRegistrar;

class CompileManagement
{
    private $driver = null;

    private $driverPrefix = null;

    private $modulesPaths = null;

    private $pluginsPaths = null;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;

        if (ExternalDirectory::hasDirectory()) {
            ExternalDirectory::scan();
        }

        $this->modulesPaths = BundleRegistrar::getPaths(BundleRegistrar::MODULE);

        $this->pluginsPaths = BundleRegistrar::getPaths(BundleRegistrar::PLUGIN);
    }

    /**
     * Get the value of driverPrefix
     */
    public function getDriverPrefix()
    {
        return $this->driverPrefix;
    }

    /**
     * Set the value of driverPrefix
     *
     * @return  self
     */
    public function setDriverPrefix($driverPrefix)
    {
        $this->driverPrefix = $driverPrefix;
        return $this;
    }

    public function compiling($consoleOutput = null)
    {
        $driver = $this->driver->setPrefix($this->getDriverPrefix());

        $consoleOutput?->info('Modules Compiling');
        $this->modulesCompiling($driver, $consoleOutput);

        $consoleOutput?->info('Plugins Compiling');
        $this->pluginsCompiling($driver, $consoleOutput);

        $consoleOutput?->info('Appends Compiling');
        $this->AppendsCompiling($driver, $consoleOutput);
    }

    private function modulesCompiling($driver, $consoleOutput)
    {
        array_map(function ($compile) use ($driver, $consoleOutput) {
            $compileObj = new $compile($driver);
            $compileObj->manage($this->modulesPaths, $consoleOutput);
        }, $this->moduleCompiles());
    }

    private function pluginsCompiling($driver, $consoleOutput)
    {
        array_map(function ($compile) use ($driver, $consoleOutput) {
            $compileObj = new $compile($driver);
            $compileObj->manage($this->pluginsPaths, $consoleOutput);
        }, $this->PluginCompiles());
    }

    private function AppendsCompiling($driver, $consoleOutput)
    {
        array_map(function ($compile) use ($driver, $consoleOutput) {
            $compileObj = new $compile($driver);
            $compileObj->manage(array_merge($this->modulesPaths, $this->pluginsPaths), $consoleOutput);
        }, $this->AppendsCompiles());
    }

    private function moduleCompiles()
    {
        return [
            InfoCompile::class,
            NavbarCompile::class,
            RoutesDashboardCompile::class,
            RoutesApiCompile::class,
            FormsCompile::class,
            GridsCompile::class,
            ViewsCompile::class,
            WidgetsCompile::class,
            ACLCompile::class,
            MigrationsCompile::class,
            SeedsCompile::class,
        ];
    }

    private function PluginCompiles()
    {
        return [
            NavbarPluginCompile::class,
            RoutesDashboardPluginCompile::class,
            RoutesApiPluginCompile::class,
            FormsPluginCompile::class,
            GridsPluginCompile::class,
            ViewsPluginCompile::class,
            ACLPluginCompile::class,
            MigrationsPluginCompile::class,
        ];
    }

    private function AppendsCompiles()
    {
        return [
            NavbarAppendsCompile::class,
            ViewsAppendsCompile::class,
        ];
    }
}
