<?php

namespace Obelaw\Compiles\Scan\Modules;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\Abstracts\Compile;

class MigrationsCompile extends Compile
{
    public $driverKey = 'obelawMigration';

    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $outoutMigrations = [];

        $consoleOutput?->writeln('Migrations Compile...');

        foreach ($paths as $id => $path) {
            $pathInfoFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'migrations.php';

            if (file_exists($pathInfoFile)) {
                $outoutMigrations = array_merge($outoutMigrations, require $pathInfoFile);
            }
        }

        $consoleOutput?->writeln('Forms Compiled.');
        $consoleOutput?->newLine();

        return $outoutMigrations;
    }
}
