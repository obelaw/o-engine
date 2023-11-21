<?php

namespace Obelaw;

use Obelaw\DriverManage;
use Obelaw\Drivers\CacheDriver;
use Obelaw\Schema\BundleRegistrar;

class CompileManage
{
    private $driverPrefix = null;
    private $modulesPaths = null;

    public function __construct()
    {
        $this->modulesPaths = BundleRegistrar::getPaths(BundleRegistrar::MODULE);
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
        $driver = new CacheDriver($this->getDriverPrefix());

        foreach ($this->moduleCompiles() as $compile) {
            $compileObj = new $compile(new DriverManage($driver));
            $compileObj->manage($this->modulesPaths, $consoleOutput);
        }
    }

    private function moduleCompiles()
    {
        return [];
    }
}
