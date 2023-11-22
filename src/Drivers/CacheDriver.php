<?php

namespace Obelaw\Drivers;

use Illuminate\Support\Facades\Cache;
use Obelaw\Drivers\Abstracts\Driver;

class CacheDriver extends Driver
{
    public function set($key, $values)
    {
        Cache::forever($this->getPrefix() . $key, $values);
    }

    public function get($key)
    {
        return Cache::get($this->getPrefix() . $key);
    }
}
