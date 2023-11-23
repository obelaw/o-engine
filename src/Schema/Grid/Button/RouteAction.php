<?php

namespace Obelaw\Schema\Grid\Button;

use Obelaw\Schema\Common\ActionButton;

class RouteAction extends ActionButton
{
    public function __construct(
        string $href,
        string $color = 'primary',
        string $permission = null
    ) {
        $this->button = [
            'type' => 'route',
            'color' => $color,
            'route' => $href,
            'permission' => $permission,
        ];
    }
}
