<?php

namespace Obelaw\Render;

use Illuminate\Support\Traits\Macroable;
use Obelaw\Drivers\Abstracts\Driver;
use Obelaw\Framework\Console\AddDefaultAdminCommand;
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

    /**
     * Get the value of cachePrefix
     */
    public function getCachePrefix()
    {
        return $this->cachePrefix;
    }

    /**
     * Set the value of cachePrefix
     *
     * @return  self
     */
    public function setCachePrefix($cachePrefix)
    {
        $this->cachePrefix = $cachePrefix;

        return $this;
    }

    // /**
    //  * Get the value of actives
    //  */
    // // public function getActives()
    // // {
    // //     return $this->actives;
    // // }

    // // /**
    // //  * Set the value of actives
    // //  *
    // //  * @return  self
    // //  */
    // // public function setActives(array $actives = [])
    // // {
    // //     $this->actives = $actives;

    // //     return $this;
    // // }

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
        $modules = $this->driver
            ->setPrefix($this->getCachePrefix())
            ->get('obelawModules');

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

    /**
     * Get the value of forms
     */
    // public function getForms($id = null)
    // {
    //     $forms = $this->driver
    //         ->setPrefix($this->getCachePrefix())
    //         ->get('obelawForms');

    //     if (!is_null($id)) {
    //         return $forms[$id] ?? null;
    //     }

    //     return $forms;
    // }

    // public function getFormFields($id)
    // {
    //     return static::getForms($id)['fields'];
    // }

    // public function getFormTabs($id)
    // {
    //     return static::getForms($id)['tabs'] ?? null;
    // }

    // public function getFormActions($id)
    // {
    //     return static::getForms($id)['actions'];
    // }

    /**
     * Get the value of grids
     */
    // public function getGrids($id = null)
    // {
    //     $grids = $this->driver
    //         ->setPrefix($this->getCachePrefix())
    //         ->get('obelawGrids');

    //     if (!is_null($id)) {
    //         return $grids[$id] ?? null;
    //     }

    //     return $grids;
    // }

    /**
     * Get the value of views
     */
    // public function getViews($id = null)
    // {
    //     $views = $this->driver
    //         ->setPrefix($this->getCachePrefix())
    //         ->get('obelawViews');

    //     if (!is_null($id)) {
    //         return $views[$id] ?? null;
    //     }

    //     return $views;
    // }

    // public function getWidgets($id = null)
    // {
    //     $Widgets = $this->driver
    //         ->setPrefix($this->getCachePrefix())
    //         ->get('obelawWidgets');

    //     if (!is_null($id)) {
    //         return $Widgets[$id] ?? null;
    //     }

    //     return $Widgets;
    // }

    /**
     * Get the value of routes
     */
    // public function getDashboardRoutes()
    // {
    //     $routes = $this->driver
    //         ->setPrefix($this->getCachePrefix())
    //         ->get('obelawDashboardRoutes');

    //     return $this->BundlesDisable($routes);
    // }

    /**
     * Get the value of routes
     */
    // public function getApiRoutes()
    // {
    //     $routes = $this->driver
    //         ->setPrefix($this->getCachePrefix())
    //         ->get('obelawApiRoutes');

    //     return $this->BundlesDisable($routes);
    // }

    /**
     * Get the value of navbars
     */
    // public function getNavbars($id = null)
    // {
    //     $navbars = $this->driver
    //         ->setPrefix($this->getCachePrefix())
    //         ->get('obelawNavbars');

    //     $navbars = $this->BundlesDisable($navbars);

    //     if (!is_null($id) && isset($navbars[$id])) {
    //         return $navbars[$id];
    //     }

    //     return $navbars;
    // }

    /**
     * Get the value of ACLs
     */
    // public function getACLs()
    // {
    //     $ACLs = $this->driver
    //         ->setPrefix($this->getCachePrefix())
    //         ->get('obelawACLs');

    //     return $this->BundlesDisable($ACLs);
    // }

    /**
     * Get the value of migrations
     */
    // public function getMigrations()
    // {
    //     $migratePath = [
    //         '/vendor/obelaw/framework/database/migrations'
    //     ];

    //     $migrations = $this->driver
    //         ->setPrefix($this->getCachePrefix())
    //         ->get('obelawMigration');

    //     return array_merge(
    //         $migratePath,
    //         $migrations
    //     );
    // }

    /**
     * Get the value of Seeds
     */
    // public function getSeeds()
    // {
    //     return $this->driver
    //         ->setPrefix($this->getCachePrefix())
    //         ->get('obelawSeeds');
    // }

    /**
     * Get the value of at install
     */
    public function getAtInstalls()
    {
        return array_merge(
            $this->driver
                ->setPrefix($this->getCachePrefix())
                ->get('obelawInstallCommands'),
            [
                AddDefaultAdminCommand::class,
            ]
        );
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

    // public function setup()
    // {
    //     $bundlesSetup = new BundlesSetup();
    //     $bundlesSetup->run();
    // }
}
