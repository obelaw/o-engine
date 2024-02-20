<?php

namespace Obelaw\Compiles\Plugins;

use Illuminate\Console\OutputStyle;
use Obelaw\Compiles\RoutesDashboardCompile;
use Obelaw\Facades\Bundles;

class RoutesDashboardPluginCompile extends RoutesDashboardCompile
{
    public function scanner($paths, OutputStyle $consoleOutput = null)
    {
        $consoleOutput?->writeln('Routes for plugin Compile...');

        $this->routes = Bundles::getDashboardRoutes();

        $outRoutes = [];
        foreach ($paths as $id => $path) {
            $pathRoutesFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'dashboard.php';

            if (file_exists($pathRoutesFile)) {
                $outRoutes[$id] = $pathRoutesFile;
            }
        }

        $consoleOutput?->writeln('Routes for plugin Compiled.');
        $consoleOutput?->newLine();

        return array_merge(Bundles::getDashboardRoutes(), $outRoutes);
    }
}
