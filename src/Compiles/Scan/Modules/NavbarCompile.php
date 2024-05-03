<?php

namespace Obelaw\Compiles\Scan\Modules;

use Obelaw\Compiles\Abstracts\Compile;
use Obelaw\Schema\Navbar\Links;

class NavbarCompile extends Compile
{
    public $driverKey = 'obelawNavbars';

    public function scanner($paths)
    {
        $outNavbars = [];

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

        return $outNavbars;
    }
}
