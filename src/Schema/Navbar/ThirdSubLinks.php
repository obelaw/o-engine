<?php

namespace Obelaw\Schema\Navbar;

class ThirdSubLinks
{
    private $links = [];

    public function link($icon, $label, $href, $permission = null, $position = 999)
    {
        $link = [
            'icon' => $icon,
            'label' => $label,
            'href' => $href,
            'permission' => $permission,
            'position' => $position,
        ];

        $link['icon'] = (file_exists(public_path($link['icon']))) ? $link['icon'] : 'vendor/obelaw/images/default.svg';

        array_push($this->links, $link);

        return $this;
    }

    public function getLinks()
    {
        return $this->links;
    }
}
