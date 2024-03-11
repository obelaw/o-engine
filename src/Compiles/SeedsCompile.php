<?php

namespace Obelaw\Compiles;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\Abstracts\Compile;
use Obelaw\Schema\Seed\Seed;

class SeedsCompile extends Compile
{
    public $driverKey = 'obelawSeeds';

    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $outSeeds = [];

        $consoleOutput?->writeln('Seeds Compile...');

        foreach ($paths as $id => $path) {
            $pathSeedFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'seeds.php';

            if (file_exists($pathSeedFile)) {
                $seeds = require $pathSeedFile;

                $seed = new Seed;

                $seeds->seeds($seed);

                $outSeeds = array_merge($outSeeds, $seed->getSeeds());
            }
        }

        $consoleOutput?->writeln('Seeds Compiled.');

        return $outSeeds;
    }
}
