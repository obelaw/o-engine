<?php

namespace Obelaw\Compiles\Scan\Modules;

use Obelaw\Compiles\Abstracts\Compile;

class RoutesApiCompile extends Compile
{
    public $driverKey = 'obelawApiRoutes';

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

    public function scanner($paths)
    {

        foreach ($paths as $id => $path) {
            $pathRoutesFile = $path . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'api.php';

            if (file_exists($pathRoutesFile)) {
                $this->setRoute($id, $pathRoutesFile);
            }
        }


        return $this->getRoutes();
    }
}
