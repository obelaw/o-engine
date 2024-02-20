<?php

namespace Obelaw\Compiles\Abstracts;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\Filters\FiltersManagement;

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
        if (is_null($this->driverKey)) {
            throw new \Exception('This driverKey must be a string');
        }

        $this->driver->set($this->driverKey, $this->filtersValues($values));
    }

    public function manage($paths, OutputStyle $consoleOutput = null)
    {
        $this->setToDriver(
            $this->scanner($paths, $consoleOutput)
        );
    }

    private function filtersValues($values)
    {
        $filters = FiltersManagement::getFilters($this->driverKey);

        if ($filters) {
            foreach ($filters as $filter) {
                $values = (new $filter)->apply($values);
            }
        }

        return $values;
    }
}
