<?php

namespace Obelaw\Compiles\Scan\Plugins;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\Scan\Modules\ViewsCompile;
use Obelaw\Facades\Bundles;
use Obelaw\Schema\View\Button;
use Obelaw\Schema\View\Tabs;

class ViewsPluginCompile extends ViewsCompile
{
    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $outViews = Bundles::getViews();

        $consoleOutput?->writeln('Views for plugin Compile...');

        foreach ($paths as $id => $path) {
            $_view = [];

            if (is_dir($path . DIRECTORY_SEPARATOR . 'etc/views')) {
                foreach (glob($path . DIRECTORY_SEPARATOR . 'etc/views/*.php') as $filename) {
                    $viewClass = require $filename;
                    $viewClass = new $viewClass;

                    //Columns class
                    $tabs = new Tabs;
                    $buttons = new Button;

                    $viewClass->tabs($tabs);

                    if (method_exists($viewClass, 'magicButtons')) {
                        $viewClass->magicButtons($buttons);
                    }

                    $_view[$id . '_' . basename($filename, '.php')] = [
                        'tabs' => $tabs->getTabs(),
                        'buttons' => (method_exists($viewClass, 'magicButtons')) ? $buttons->getButtons() : null,
                    ];
                }

                $outViews = array_merge($outViews, $_view);
            }
        }

        $consoleOutput?->writeln('Views for plugin Compiled.');
        $consoleOutput?->newLine();

        return $outViews;
    }
}
