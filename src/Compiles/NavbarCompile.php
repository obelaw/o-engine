<?php

namespace Obelaw\Compiles;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\Abstracts\Compile;
use Obelaw\Schema\Navbar\Links;

class NavbarCompile extends Compile
{
    public $driverKey = 'obelawNavbars';

    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $outNavbars = [];
        $bar = null;

        $consoleOutput?->info('Navbars Compile...');

        if ($consoleOutput) {
            $bar = $consoleOutput->createProgressBar(count($paths));
            $bar->start();
        }

        foreach ($paths as $id => $path) {
            $pathNavbarFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'navbar.php';

            if (file_exists($pathNavbarFile)) {
                $navbar = require $pathNavbarFile;
                $navbar = new $navbar;

                $link = new Links;

                $navbar->navbar($link);

                if (!property_exists($navbar, 'appendTo')) {
                    $outNavbars = array_merge($outNavbars, [$id => $link->getLinks()]);
                }
            }

            $bar?->advance();
        }

        $bar?->finish();

        $consoleOutput?->info('Navbars Compiled.');

        return $outNavbars;
    }
}
