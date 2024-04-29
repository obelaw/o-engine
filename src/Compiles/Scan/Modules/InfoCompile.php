<?php

namespace Obelaw\Compiles\Scan\Modules;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\Abstracts\Compile;
use Obelaw\Schema\ModuleInfo;

class InfoCompile extends Compile
{
    public $driverKey = 'obelawModules';

    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $outBundles = [];

        $consoleOutput?->writeln('Info Compile...');

        foreach ($paths as $id => $path) {
            $pathInfoFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'info.php';

            if (file_exists($pathInfoFile)) {
                $moduleInfo = require $pathInfoFile;

                $schemaModuleInfo = new ModuleInfo;

                $moduleInfo->setInfo($schemaModuleInfo);

                $outBundles = array_merge($outBundles, [$id => $schemaModuleInfo->getInfo()]);
            }
        }

        $consoleOutput?->writeln('Info Compiled.');
        $consoleOutput?->newLine();

        return $outBundles;
    }
}
