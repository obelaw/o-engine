<?php

namespace Obelaw\Compiles\Scan\Modules;

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
        $consoleOutput?->writeln('Routes Compile...');

        foreach ($paths as $id => $path) {
            $pathRoutesFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'dashboard.php';

            if (file_exists($pathRoutesFile)) {
                $this->setRoute($id, $pathRoutesFile);
            }
        }

        $consoleOutput?->writeln('Routes Compiled.');
        $consoleOutput?->newLine();

        return $this->getRoutes();
    }
}
