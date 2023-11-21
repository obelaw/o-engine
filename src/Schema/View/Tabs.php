<?php

namespace Obelaw\Schema\View;

class Tabs
{
    public $tabs = [];

    public function addTab($label, $component)
    {
        $this->tabs = array_merge($this->tabs, [$label => $component]);

        return $this;
    }

    public function getTabs()
    {
        return $this->tabs;
    }
}
