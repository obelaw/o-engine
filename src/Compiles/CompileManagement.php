<?php

namespace Obelaw\Compiles;

use Obelaw\Compiles\ACLCompile;
use Obelaw\Compiles\FormsCompile;
use Obelaw\Compiles\GridsCompile;
use Obelaw\Compiles\InfoCompile;
use Obelaw\Compiles\MigrationsCompile;
use Obelaw\Compiles\NavbarCompile;
use Obelaw\Compiles\RoutesCompile;
use Obelaw\Compiles\ViewsCompile;
use Obelaw\Drivers\Abstracts\Driver;
use Obelaw\Schema\BundleRegistrar;

class CompileManagement
{
    private $driver = null;

    private $driverPrefix = null;

    private $modulesPaths = null;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;

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
        $driver = $this->driver->setPrefix($this->getDriverPrefix());

        foreach ($this->moduleCompiles() as $compile) {
            $compileObj = new $compile($driver);
            $compileObj->manage($this->modulesPaths, $consoleOutput);
        }
    }

    private function moduleCompiles()
    {
        return [
            InfoCompile::class,
            NavbarCompile::class,
            RoutesCompile::class,
            FormsCompile::class,
            GridsCompile::class,
            ViewsCompile::class,
            ACLCompile::class,
            MigrationsCompile::class,
        ];
    }
}
