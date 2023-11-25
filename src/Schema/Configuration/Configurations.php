<?php

namespace Obelaw\Schema\Configuration;

class Configurations
{
    public $providers = [];

    public function setProvider($providerClass)
    {
        array_push($this->providers, $providerClass);
    }

    public function getProviders()
    {
        return $this->providers;
    }
}
