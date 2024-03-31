<?php

namespace Obelaw\Render;

class BundlesPool
{
    const LEVELONE = '/*/obelaw.php';
    const LEVELTWO = '/**/*/obelaw.php';

    private static $poolPaths = [];

    /**
     * setPoolPath
     *
     */
    public static function setPoolPath($path, $level = null)
    {
        array_push(static::$poolPaths, [
            'level' => $level ?? self::LEVELTWO,
            'path' => $path
        ]);
    }

    /**
     * hasDirectory
     *
     */
    public static function hasPools()
    {
        return (count(static::$poolPaths) != 0) ? true : false;
    }

    public static function scan()
    {
        foreach (static::$poolPaths as $scan) {
            foreach (glob($scan['path'] . $scan['level']) as $obelaw) {
                require $obelaw;
            }
        }
    }
}
