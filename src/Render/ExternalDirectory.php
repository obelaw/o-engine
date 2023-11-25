<?php

namespace Obelaw\Render;

class ExternalDirectory
{
    private static $directoryPaths = [];

    /**
     * Set the value of directoryPaths
     *
     */
    public static function setDirectoryPath($directoryPath)
    {
        array_push(static::$directoryPaths, $directoryPath);
    }

    /**
     * Set the value of directoryPaths
     *
     */
    public static function hasDirectory()
    {
        return (count(static::$directoryPaths) != 0) ? true : false;
    }

    public static function scan()
    {
        foreach (static::$directoryPaths as $path) {
            foreach (glob($path . '/**/*/obelaw.php') as $obelaw) {
                require $obelaw;
            }
        }
    }
}
