<?php

namespace Obelaw\Compiles\Scan\Modules;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\Abstracts\Compile;
use Obelaw\Schema\Navbar\Links;

class NavbarCompile extends Compile
{
    public $driverKey = 'obelawNavbars';

    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $outNavbars = [];

        $consoleOutput?->writeln('Navbars Compile...');

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
        }

        $consoleOutput?->writeln('Navbars Compiled.');
        $consoleOutput?->newLine();

        return $outNavbars;
    }
}
