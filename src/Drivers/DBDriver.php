<?php

namespace Obelaw\Drivers;

use Obelaw\Drivers\Abstracts\Driver;
use Obelaw\Models\Compile;

class DBDriver extends Driver
{
    public function set($key, $values)
    {
        Compile::updateOrCreate(['key' => $this->getPrefix() . $key], ['value' => $values]);
    }

    public function get($key)
    {
        return Compile::where('key', $this->getPrefix() . $key)->first()->value;
    }
}
