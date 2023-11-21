<?php

namespace Obelaw\Drivers;

use Illuminate\Support\Facades\Cache;
use Obelaw\Drivers\Abstracts\Driver;

class CacheDriver extends Driver
{
    public function __construct(
        public $prefix = null
    ) {
    }

    public function set($key, $values)
    {
        Cache::forever($this->prefix . $key, $values);
    }
}
