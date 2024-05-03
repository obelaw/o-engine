<?php

namespace Obelaw\Compiles\Scan\Modules;

use Obelaw\Compiles\Abstracts\Compile;
use Obelaw\Schema\ModuleInfo;

class InfoCompile extends Compile
{
    public $driverKey = 'obelawModules';

    public function scanner($paths)
    {
        $outBundles = [];

        foreach ($paths as $id => $path) {
            $pathInfoFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'info.php';

            if (file_exists($pathInfoFile)) {
                $moduleInfo = require $pathInfoFile;

                $schemaModuleInfo = new ModuleInfo;

                $moduleInfo->setInfo($schemaModuleInfo);

                $outBundles = array_merge($outBundles, [$id => $schemaModuleInfo->getInfo()]);
            }
        }

        return $outBundles;
    }
}
