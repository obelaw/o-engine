<?php

namespace Obelaw;

use Obelaw\Drivers\Abstracts\Driver;

class DriverManage
{
    public function __construct(
        public Driver $driver
    ) {
    }

    public function set(string $key, array $values = [])
    {
        $this->driver->set($key, $values);
    }
}
