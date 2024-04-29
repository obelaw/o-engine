<?php

namespace Obelaw\Compiles;

use Obelaw\Compiles\Appends\NavbarAppendsCompile;
use Obelaw\Compiles\Appends\ViewsAppendsCompile;
use Obelaw\Compiles\Plugins\ACLPluginCompile;
use Obelaw\Compiles\Plugins\FormsPluginCompile;
use Obelaw\Compiles\Plugins\GridsPluginCompile;
use Obelaw\Compiles\Plugins\MigrationsPluginCompile;
use Obelaw\Compiles\Plugins\NavbarPluginCompile;
use Obelaw\Compiles\Plugins\RoutesApiPluginCompile;
use Obelaw\Compiles\Plugins\RoutesDashboardPluginCompile;
use Obelaw\Compiles\Plugins\ViewsPluginCompile;
use Obelaw\Drivers\Abstracts\Driver;
use Obelaw\Render\BundlesPool;
use Obelaw\Schema\BundleRegistrar;

class CompileManagement
{
    private $driver = null;

    private $driverPrefix = null;

    private $modulesPaths = null;
    private $scaneersModuleCompiles = [];
    private $pluginsPaths = null;
    private $scaneersPluginCompiles = [];


    public function __construct(Driver $driver)
    {
        $this->driver = $driver;

        if (BundlesPool::hasPools()) {
            BundlesPool::scan();
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

        // $consoleOutput?->info('Appends Compiling');
        // $this->AppendsCompiling($driver, $consoleOutput);
    }

    public function mergeModuleScaneers(array $scaneers)
    {
        $this->scaneersModuleCompiles = array_merge($this->scaneersModuleCompiles, $scaneers);
    }

    public function mergePluginScaneers(array $scaneers)
    {
        $this->scaneersPluginCompiles = array_merge($this->scaneersPluginCompiles, $scaneers);
    }

    private function modulesCompiling($driver, $consoleOutput)
    {
        array_map(function ($compile) use ($driver, $consoleOutput) {
            $compileObj = new $compile($driver);
            $compileObj->manage($this->modulesPaths, $consoleOutput);
        }, $this->scaneersModuleCompiles);
    }

    private function pluginsCompiling($driver, $consoleOutput)
    {
        array_map(function ($compile) use ($driver, $consoleOutput) {
            $compileObj = new $compile($driver);
            $compileObj->manage($this->pluginsPaths, $consoleOutput);
        }, $this->scaneersPluginCompiles);
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
            //
        ];
    }

    private function PluginCompiles()
    {
        return [
            //
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
