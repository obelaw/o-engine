<?php

namespace Obelaw\Schema\Configuration;

class Configurations
{
    public $activate = true;

    public $providers = [];

    public function setProvider($providerClass)
    {
        array_push($this->providers, $providerClass);
    }

    public function getProviders()
    {
        return $this->providers;
    }

    public function deactivate()
    {
        return $this->activate = false;
    }

    public function getActivateStatus()
    {
        return $this->activate;
    }
}
