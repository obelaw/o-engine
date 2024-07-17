<?php

namespace Obelaw\Compiles;

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
    private array $disableAddons = [];

    public function __construct(Driver $driver, array $disableAddons = [])
    {
        $this->driver = $driver;
        $this->disableAddons = $disableAddons;

        if (BundlesPool::hasPools()) {
            BundlesPool::scan();
        }

        // dd(
        //     $this->disableAddons(BundleRegistrar::getPaths(BundleRegistrar::MODULE))
        // );

        $this->modulesPaths = $this->disableAddons(BundleRegistrar::getPaths(BundleRegistrar::MODULE));

        $this->pluginsPaths = $this->disableAddons(BundleRegistrar::getPaths(BundleRegistrar::PLUGIN));
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

    /**
     * Get the value of disableAddons
     */
    public function getDisableAddons()
    {
        return $this->disableAddons;
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

    private function disableAddons($addons)
    {
        if (empty($this->getDisableAddons()))
            return $addons;

        foreach ($this->getDisableAddons() as $addon) {
            unset($addons[$addon]);
        }

        return $addons;
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
