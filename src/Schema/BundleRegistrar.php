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

    private static $providers = [];

    public static function register($type, $bundleName, $path, $configCallback = null)
    {
        self::$paths[$type][$bundleName] = str_replace('\\', '/', $path);

        if ($configCallback) {
            $configurations = new Configurations;
            $configCallback($configurations);

            if ($providers = $configurations->getProviders()) {
                self::$providers[$bundleName] = $providers;
            }
        }
    }

    public static function getPaths($type)
    {
        return self::$paths[$type];
    }

    public static function getProviders()
    {
        return self::$providers;
    }
}
