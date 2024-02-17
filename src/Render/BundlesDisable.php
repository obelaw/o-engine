<?php

namespace Obelaw\Render;

class BundlesDisable
{
    private static $disables = [];

    /**
     * 
     */
    public static function disable($bundle)
    {
        array_push(static::$disables, $bundle);
    }

    public static function disableList()
    {
        return array_merge(
            static::$disables,
            config('obelaw.engine.bundles.disables', [])
        );
    }

    public static function disabledCount()
    {
        return count(static::$disables);
    }
}
