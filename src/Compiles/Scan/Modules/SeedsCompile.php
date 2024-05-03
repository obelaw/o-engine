<?php

namespace Obelaw\Compiles\Scan\Modules;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\Abstracts\Compile;
use Obelaw\Schema\Seed\Seed;

class SeedsCompile extends Compile
{
    public $driverKey = 'obelawSeeds';

    public function scanner($paths)
    {
        $outSeeds = [];


        foreach ($paths as $id => $path) {
            $pathSeedFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'seeds.php';

            if (file_exists($pathSeedFile)) {
                $seeds = require $pathSeedFile;

                $seed = new Seed;

                $seeds->seeds($seed);

                $outSeeds = array_merge($outSeeds, $seed->getSeeds());
            }
        }

        return $outSeeds;
    }
}
