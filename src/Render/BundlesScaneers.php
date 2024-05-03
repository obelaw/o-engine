<?php

namespace Obelaw\Render;

use Obelaw\Schema\Scaneer\Scaneer;

class BundlesScaneers
{
    private static $scaneersModuleCompiles = [];
    private static $scaneersPluginCompiles = [];
    private static $scaneersAppendsCompiles = [];

    private static function sortScaneers($scaneers)
    {
        $collection = collect($scaneers);
        $collection = $collection->sortBy('position');
        $collection = $collection->map(function (array $item) {
            return $item['scaneer'];
        });

        return $collection->all();
    }

    public static function mergeModuleScaneers($cb)
    {
        $objectScaneer = new Scaneer;

        $cb($objectScaneer);

        $objectScaneer->scaneers();

        static::$scaneersModuleCompiles = array_merge(static::$scaneersModuleCompiles, $objectScaneer->scaneers());
    }

    public static function getModuleScaneers()
    {
        return static::sortScaneers(static::$scaneersModuleCompiles);
    }

    public static function mergePluginScaneers($cb)
    {
        $objectScaneer = new Scaneer;

        $cb($objectScaneer);

        $objectScaneer->scaneers();

        static::$scaneersPluginCompiles = array_merge(static::$scaneersPluginCompiles, $objectScaneer->scaneers());
    }

    public static function getPluginScaneers()
    {
        return static::sortScaneers(static::$scaneersPluginCompiles);
    }

    public static function mergeAppendScaneers($cb)
    {
        $objectScaneer = new Scaneer;

        $cb($objectScaneer);

        $objectScaneer->scaneers();

        static::$scaneersAppendsCompiles = array_merge(static::$scaneersAppendsCompiles, $objectScaneer->scaneers());
    }

    public static function getAppendScaneers()
    {
        return static::sortScaneers(static::$scaneersAppendsCompiles);
    }
}
