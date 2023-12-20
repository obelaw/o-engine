<?php

namespace Obelaw\Compiles;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\Abstracts\Compile;

class RoutesDashboardCompile extends Compile
{
    public $driverKey = 'obelawDashboardRoutes';

    private $routes = [];

    private function setRoute($id, $path)
    {
        $route[$id] = $path;

        $this->routes = array_merge($this->routes, $route);
    }

    private function getRoutes()
    {
        return $this->routes;
    }

    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $bar = null;

        $consoleOutput?->info('Routes Compile...');

        if ($consoleOutput) {
            $bar = $consoleOutput->createProgressBar(count($paths));
            $bar->start();
        }

        foreach ($paths as $id => $path) {
            $pathRoutesFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'dashboard.php';

            if (file_exists($pathRoutesFile)) {
                $this->setRoute($id, $pathRoutesFile);
                $bar?->advance();
            }
        }

        $bar?->finish();

        $consoleOutput?->info('Routes Compiled.');

        return $this->getRoutes();
    }
}
