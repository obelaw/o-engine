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
use Obelaw\Render\BundlesScaneers;
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
        $consoleOutput?->newLine(3);


        $consoleOutput?->info('Plugins Compiling');
        $this->pluginsCompiling($driver, $consoleOutput);
        $consoleOutput?->newLine(3);

        $consoleOutput?->info('Appends Compiling');
        $this->AppendsCompiling($driver, $consoleOutput);
        $consoleOutput?->newLine(3);
    }

    private function modulesCompiling($driver, $consoleOutput)
    {
        $scaneers = BundlesScaneers::getModuleScaneers();
        $this->progress($scaneers, $this->modulesPaths, $driver, $consoleOutput);
    }

    private function pluginsCompiling($driver, $consoleOutput)
    {
        $scaneers = BundlesScaneers::getPluginScaneers();
        $this->progress($scaneers, $this->pluginsPaths, $driver, $consoleOutput);
    }

    private function AppendsCompiling($driver, $consoleOutput)
    {
        $scaneers = BundlesScaneers::getAppendScaneers();
        $this->progress($scaneers, array_merge($this->modulesPaths, $this->pluginsPaths), $driver, $consoleOutput);
    }

    private function progress($scaneers, $bundles, $driver, $consoleOutput)
    {
        $progressBar = $consoleOutput->createProgressBar(count($scaneers));
        $progressBar->setFormat("%current%/%max% [%bar%] %percent:3s%% (%message%)");

        $progressBar->setMessage('Starting...');
        $progressBar->start();

        foreach ($scaneers as $compile) {
            $compileObj = new $compile($driver);
            $compileObj->manage($bundles);

            $progressBar->setMessage($compile);
            $progressBar->advance();
        }

        $progressBar->setMessage('Finished!');
        $progressBar->finish();
    }
}
