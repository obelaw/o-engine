<?php

namespace Obelaw\Schema\Configuration;

class Configurations
{
    public $activate = true;

    public function deactivate()
    {
        return $this->activate = false;
    }

    public function getActivateStatus()
    {
        return $this->activate;
    }
}
