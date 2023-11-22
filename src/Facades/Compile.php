<?php

namespace Obelaw\Facades;

use Illuminate\Support\Facades\Facade;

class Compile extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'obelaw.o.compile';
    }
}
