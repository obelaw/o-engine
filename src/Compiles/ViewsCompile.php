<?php

namespace Obelaw\Compiles;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\Abstracts\Compile;
use Obelaw\Schema\View\Button;
use Obelaw\Schema\View\Tabs;

class ViewsCompile extends Compile
{
    public $driverKey = 'obelawViews';

    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $outViews = [];
        $bar = null;

        $consoleOutput?->info('Views Compile...');

        foreach ($paths as $id => $path) {
            $_view = [];

            if (is_dir($path . DIRECTORY_SEPARATOR . 'etc/views')) {

                if ($consoleOutput) {
                    $bar = $consoleOutput->createProgressBar(count(glob($path . DIRECTORY_SEPARATOR . 'etc/views/*.php')));
                    $bar->start();
                }

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

                    $bar?->advance();
                }

                $bar?->finish();

                $outViews = array_merge($outViews, $_view);
            }
        }

        $consoleOutput?->info('Views Compiled.');

        return $outViews;
    }
}
