<?php

namespace Obelaw\Facades;

use Illuminate\Support\Facades\Facade;

class Bundles extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'obelaw.o.bundles';
    }
}
