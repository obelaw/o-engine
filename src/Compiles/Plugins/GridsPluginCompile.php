<?php

namespace Obelaw\Compiles\Plugins;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\GridsCompile;
use Obelaw\Facades\Bundles;
use Obelaw\Schema\Grid\Button;
use Obelaw\Schema\Grid\CTA;
use Obelaw\Schema\Grid\Table;

class GridsPluginCompile extends GridsCompile
{
    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $outGrids = Bundles::getGrids();


        $consoleOutput?->writeln('Grids for plugin Compile...');

        foreach ($paths as $id => $path) {
            $_grid = [];

            if (is_dir($path . DIRECTORY_SEPARATOR . 'etc/grids')) {

                foreach (glob($path . DIRECTORY_SEPARATOR . 'etc/grids/*.php') as $filename) {
                    $gridClass = include($filename);

                    //Columns class
                    $table = new Table;
                    $CTA = new CTA;
                    $button = new Button;

                    if (method_exists($gridClass, 'createButton')) {
                        $gridClass->createButton($button);
                    }

                    $gridClass->table($table);
                    $gridClass->CTA($CTA);

                    $_grid[$id . '_' . basename($filename, '.php')] = [
                        'model' => (property_exists($gridClass, 'model')) ? $gridClass->model : null,
                        'where' => (property_exists($gridClass, 'where')) ? $gridClass->where : null,
                        'filter' => (property_exists($gridClass, 'filter')) ? $gridClass->filter : null,
                        'buttons' => $button->getButtons(),
                        'rows' => $table->getColumns(),
                        'CTAs' => $CTA->getCalls(),
                    ];
                }

                $outGrids = array_merge($outGrids, $_grid);
            }
        }

        $consoleOutput?->writeln('Grids for plugin Compiled.');
        $consoleOutput?->newLine();

        return $outGrids;
    }
}
