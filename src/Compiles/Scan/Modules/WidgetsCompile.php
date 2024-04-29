<?php

namespace Obelaw\Compiles\Scan\Modules;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\Abstracts\Compile;
use Obelaw\Schema\Widgets\Widgets;

class WidgetsCompile extends Compile
{
    public $driverKey = 'obelawWidgets';

    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $outoutWidgets = [];

        $consoleOutput?->writeln('Widgets Compile...');

        foreach ($paths as $id => $path) {
            $pathWidgetsFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'widgets.php';

            if (file_exists($pathWidgetsFile)) {

                $widgetsSchema = new Widgets;

                $widgetsClass = require $pathWidgetsFile;
                $widgetsClass->widgets($widgetsSchema);

                $outoutWidgets = array_merge($outoutWidgets, [$widgetsClass->id => $widgetsSchema->getWidgets()]);
            }
        }

        $consoleOutput?->writeln('Widgets Compiled.');
        $consoleOutput?->newLine();

        return $outoutWidgets;
    }
}
