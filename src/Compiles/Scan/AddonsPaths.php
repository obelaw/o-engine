<?php

namespace Obelaw\Compiles\Scan;

use Obelaw\Schema\BundleRegistrar;

class AddonsPaths
{
    private array $disableAddons = [];

    /**
     * Get the value of disableAddons
     */
    public function getDisableAddons(): array
    {
        return $this->disableAddons;
    }

    /**
     * Set the value of disableAddons
     *
     * @return  self
     */
    public function setDisableAddons(array $disableAddons): self
    {
        $this->disableAddons = $disableAddons;
        return $this;
    }

    public function getModulesPaths()
    {
        return $this->disableAddons(BundleRegistrar::getPaths(BundleRegistrar::MODULE));
    }

    public function getPluginsPaths()
    {
        return $this->disableAddons(BundleRegistrar::getPaths(BundleRegistrar::PLUGIN));
    }

    private function disableAddons($addons)
    {
        // dump($this->getDisableAddons());
        if (empty($this->getDisableAddons()))
            return $addons;

        foreach ($this->getDisableAddons() as $addon) {
            unset($addons[$addon]);
        }

        return $addons;
    }
}
