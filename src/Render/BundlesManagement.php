<?php

namespace Obelaw\Render;

use Illuminate\Support\Traits\Macroable;
use Obelaw\Drivers\Abstracts\Driver;
use Obelaw\Render\BundlesDisable;

class BundlesManagement
{
    use Macroable;

    private $driver = null;

    private $cachePrefix = null;

    // private $actives = null;

    private $aliases = [];

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }

    public function BundlesDisable($items)
    {
        $collection = collect($items);
        $collection = $collection->reject(function ($item,  $id) {
            return in_array($id, BundlesDisable::disableList());
        });

        return $collection->all();
    }

    /**
     * Get the value of modules
     */
    public function getModules($id = null)
    {
        $modules = $this->getDriver()->get('obelawModules');

        $modules = $this->BundlesDisable($modules);

        if (!is_null($id) && isset($modules[$id])) {
            return $modules[$id] ?? null;
        }

        return $modules;
    }

    /**
     * Get the value of modules
     */
    public function getModulesByGroup(array $groups = null)
    {
        $modules = $this->getModules();

        $collection = collect($modules);

        $collection = $collection->map(function ($item,  $id) {
            $item['id'] = $id;
            return $item;
        });

        $collection = $collection->groupBy('group');

        if ($groups) {
            return $collection->only($groups);
        }

        return $collection->all();
    }


    public function hasModule($id)
    {
        $modules = $this->getModules();

        if (isset($modules[$id])) {
            return true;
        }

        return false;
    }

    public function pluginAlias($from, $to)
    {
        $this->aliases = array_merge($this->aliases, [$from => $to]);
    }

    public function getPluginAliases()
    {
        return $this->aliases;
    }
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Set the value of driver
     *
     * @return  self
     */
    public function setDriver(Driver $driver)
    {
        $this->driver = $driver;
        return $this;
    }
}
