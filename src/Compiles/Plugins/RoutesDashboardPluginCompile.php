<?php

namespace Obelaw\Compiles\Plugins;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\RoutesDashboardCompile;
use Obelaw\Facades\Bundles;

class RoutesDashboardPluginCompile extends RoutesDashboardCompile
{
    private $routes = [];

    private function setRoute($id, $path)
    {
        $route[$id] = $path;

        $this->routes = array_merge(Bundles::getDashboardRoutes(), $route);
    }

    private function getRoutes()
    {
        return $this->routes;
    }

    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $consoleOutput?->writeln('Routes for plugin Compile...');

        $this->routes = Bundles::getDashboardRoutes();

        foreach ($paths as $id => $path) {
            $pathRoutesFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'dashboard.php';

            if (file_exists($pathRoutesFile)) {
                $this->setRoute($id, $pathRoutesFile);
            }
        }

        $consoleOutput?->writeln('Routes for plugin Compiled.');
        $consoleOutput?->newLine();

        return $this->getRoutes();
    }
}
