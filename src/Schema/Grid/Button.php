<?php

namespace Obelaw\Schema\Grid;

class Button
{
    public $buttons = [];

    public function setButton($label, $route, $icon = 'plus', $permission = null)
    {
        $button = [
            'label' => $label,
            'route' => $route,
            'icon' => (file_exists(public_path($icon))) ? $icon : 'vendor/obelaw/images/default.svg',
            'permission' => $permission,
        ];

        array_push($this->buttons, $button);

        return $this;
    }

    public function getButtons()
    {
        return $this->buttons;
    }
}
