<?php

namespace Obelaw\Schema;

use Obelaw\Schema\Configuration\Configurations;

class BundleRegistrar
{
    const MODULE = 'module';
    const PLUGIN = 'plugin';

    private static $paths = [
        self::MODULE => [],
        self::PLUGIN => [],
    ];

    public static function register($type, $bundleName, $path, $configCallback = null)
    {
        self::$paths[$type][$bundleName] = str_replace('\\', '/', $path);

        if ($configCallback) {
            $configurations = new Configurations;
            $configCallback($configurations);

            if (!$configurations->getActivateStatus()) {
                unset(self::$paths[$type][$bundleName]);
            }
        }
    }

    public static function getPaths($type)
    {
        return self::$paths[$type];
    }
}
