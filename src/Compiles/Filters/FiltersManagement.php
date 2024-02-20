<?php

namespace Obelaw\Compiles\Filters;

class FiltersManagement
{
    private static $filters = [
        'obelawNavbars' => [
            ResortMenuLinks::class
        ],
    ];

    public static function getFilters($key)
    {
        if (isset(static::$filters[$key])) {
            return static::$filters[$key];
        }

        return null;
    }
}
