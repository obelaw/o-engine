<?php

namespace Obelaw\Compiles;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\Abstracts\Compile;
use Obelaw\Schema\ModuleInfo;

class InfoCompile extends Compile
{
    public $driverKey = 'obelawForms';

    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $outBundles = [];
        $bar = null;

        $consoleOutput?->info('Info Compile...');

        if ($consoleOutput) {
            $bar = $consoleOutput->createProgressBar(count($paths));
            $bar->start();
        }

        foreach ($paths as $id => $path) {
            $pathInfoFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'info.php';

            if (file_exists($pathInfoFile)) {
                $moduleInfo = require $pathInfoFile;

                $schemaModuleInfo = new ModuleInfo;

                $moduleInfo->setInfo($schemaModuleInfo);

                $outBundles = array_merge($outBundles, [$id => $schemaModuleInfo->getInfo()]);
            }

            $bar?->advance();
        }

        $bar?->finish();

        $consoleOutput?->info('Info Compiled.');

        return $outBundles;
    }
}
