<?php

namespace Obelaw\Schema\View;

class Button
{
    private $buttons = [];

    public function setButton($button)
    {
        // $buttons = [
        //     'label' => $label,
        //     'route' => $route,
        //     'icon' => $icon,
        // ];

        array_push($this->buttons, $button);

        return $this;
    }

    public function getButtons()
    {
        return $this->buttons;
    }
}
