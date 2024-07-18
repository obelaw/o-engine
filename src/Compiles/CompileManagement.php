<?php

namespace Obelaw\Compiles;

use Obelaw\Compiles\Scan\AddonsPaths;
use Obelaw\Drivers\Abstracts\Driver;
use Obelaw\Render\BundlesPool;
use Obelaw\Render\BundlesScaneers;

class CompileManagement
{
    private $driver = null;
    private $modulesPaths = null;
    private $pluginsPaths = null;


    public function __construct(Driver $driver, AddonsPaths $addonsPaths)
    {
        $this->driver = $driver;

        if (BundlesPool::hasPools()) {
            BundlesPool::scan();
        }

        $this->modulesPaths = $addonsPaths->getModulesPaths();
        $this->pluginsPaths = $addonsPaths->getPluginsPaths();
    }

    public function compiling($consoleOutput = null)
    {
        $driver = $this->driver;

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
