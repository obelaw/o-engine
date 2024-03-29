<?php

namespace Obelaw\Compiles;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\Abstracts\Compile;
use Obelaw\Schema\Grid\Action;
use Obelaw\Schema\Grid\Button;
use Obelaw\Schema\Grid\CTA;
use Obelaw\Schema\Grid\Table;

class GridsCompile extends Compile
{
    public $driverKey = 'obelawGrids';

    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $outGrids = [];
        $bar = null;

        $consoleOutput?->info('Grids Compile...');

        foreach ($paths as $id => $path) {
            $_grid = [];

            if (is_dir($path . DIRECTORY_SEPARATOR . 'etc/grids')) {

                if ($consoleOutput) {
                    $bar = $consoleOutput->createProgressBar(count(glob($path . DIRECTORY_SEPARATOR . 'etc/grids/*.php')));
                    $bar->start();
                }

                foreach (glob($path . DIRECTORY_SEPARATOR . 'etc/grids/*.php') as $filename) {
                    $gridClass = include($filename);

                    //Columns class
                    $table = new Table;
                    $CTA = new CTA;
                    $button = new Button;
                    $actions = new Action;

                    if (method_exists($gridClass, 'createButton')) {
                        $gridClass->createButton($button);
                    }

                    if (method_exists($gridClass, 'actions')) {
                        $gridClass->actions($actions);
                    }

                    $gridClass->table($table);
                    $gridClass->CTA($CTA);

                    $_grid[$id . '_' . basename($filename, '.php')] = [
                        'model' => (property_exists($gridClass, 'model')) ? $gridClass->model : null,
                        'where' => (property_exists($gridClass, 'where')) ? $gridClass->where : null,
                        'filter' => (property_exists($gridClass, 'filter')) ? $gridClass->filter : null,
                        'buttons' => $button->getButtons(),
                        'actions' => $actions->getActions(),
                        'rows' => $table->getColumns(),
                        'CTAs' => $CTA->getCalls(),
                    ];

                    $bar?->advance();
                }

                $bar?->finish();

                $outGrids = array_merge($outGrids, $_grid);
            }
        }

        $consoleOutput?->info('Grids Compiled.');

        return $outGrids;
    }
}
