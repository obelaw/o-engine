<?php

namespace Obelaw\Schema\Widgets;

class Widgets
{
    private $widgets = [];

    public function addWidget($component, $cols = 'col-6')
    {
        array_push($this->widgets, [
            'component' => $component,
            'cols' => $cols
        ]);

        return $this;
    }

    public function getWidgets()
    {
        return $this->widgets;
    }
}
