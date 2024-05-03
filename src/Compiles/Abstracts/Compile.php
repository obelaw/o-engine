<?php

namespace Obelaw\Compiles\Abstracts;

use Illuminate\Support\Str;
use Obelaw\Compiles\Filters\FiltersManagement;

abstract class Compile
{
    public $name = null;
    public $driverKey = null;

    public function __construct(
        protected $driver,
    ) {
    }

    abstract public function scanner($paths);

    public function getName()
    {
        return $this->name ?? Str::snake(Str::pluralStudly(class_basename($this)), ' ');
    }

    public function setToDriver($values)
    {
        if (is_null($this->driverKey)) {
            throw new \Exception('This driverKey must be a string');
        }

        $this->driver->set($this->driverKey, $this->filtersValues($values));
    }

    public function manage($paths)
    {
        $this->setToDriver(
            $this->scanner($paths)
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
