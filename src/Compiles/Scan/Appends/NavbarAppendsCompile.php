<?php

namespace Obelaw\Compiles\Scan\Appends;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\Scan\Modules\NavbarCompile;
use Obelaw\Facades\Bundles;
use Obelaw\Schema\Navbar\Links;

class NavbarAppendsCompile extends NavbarCompile
{
    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $outNavbars = Bundles::getNavbars();

        foreach ($paths as $id => $path) {
            $_outNavbars = [];

            if (is_dir($path . DIRECTORY_SEPARATOR . 'etc/appends/menus')) {

                foreach (glob($path . DIRECTORY_SEPARATOR . 'etc/appends/menus/*.php') as $filename) {

                    $navbar = require $filename;

                    $link = new Links;

                    $navbar->navbar($link);

                    foreach ($link->getPushLink() as $pushTo => $link) {

                        // Push to main menu
                        if (str_contains($pushTo, 'menu:')) {
                            $pushTo = explode(':', $pushTo)[1];
                            array_push($outNavbars[$navbar->module], $link);
                        }

                        // Push to sub menu
                        if (str_contains($pushTo, 'sub:')) {

                            $pushTo = explode(':', $pushTo)[1];

                            foreach ($outNavbars[$navbar->module] as $index => $menu) {
                                if (isset($menu['id']) && $menu['id'] == $pushTo) {
                                    array_push($menu['sublinks'], $link);
                                    $outNavbars[$navbar->module][$index]['sublinks'] = $menu['sublinks'];
                                }
                            }
                        }
                    }
                }

                $outNavbars = array_merge($outNavbars, $_outNavbars);
            }
        }

        return $outNavbars;
    }
}
