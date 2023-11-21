<?php

namespace Obelaw\Compiles\Abstracts;

use Illuminate\Console\OutputStyle;

abstract class Compile
{
    public $driverKey = null;

    public function __construct(
        protected $driver,
    ) {
    }

    abstract public function scanner($paths, OutputStyle $consoleOutput = null);

    public function setToDriver($values)
    {
        $this->driver->set($this->driverKey, $values);
    }

    public function manage($paths, OutputStyle $consoleOutput = null)
    {
        $this->setToDriver(
            $this->scanner($paths, $consoleOutput)
        );
    }
}
