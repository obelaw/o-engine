<?php

namespace Obelaw\Compiles\Plugins;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\MigrationsCompile;
use Obelaw\Facades\Bundles;

class MigrationsPluginCompile extends MigrationsCompile
{
    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $outoutMigrations = Bundles::getMigrations();

        $consoleOutput?->writeln('Migrations for plugin Compile...');

        foreach ($paths as $id => $path) {
            $pathInfoFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'migrations.php';

            if (file_exists($pathInfoFile)) {
                $outoutMigrations = array_merge($outoutMigrations, require $pathInfoFile);
            }
        }

        $consoleOutput?->writeln('Migrations for plugin Compiled.');

        return $outoutMigrations;
    }
}
