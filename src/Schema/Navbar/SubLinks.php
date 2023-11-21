<?php

namespace Obelaw\Schema\Navbar;

class SubLinks
{
    private $links = [];

    public function link($icon, $label, $href, $permission = null)
    {
        $link = [
            'icon' => $icon,
            'label' => $label,
            'href' => $href,
            'permission' => $permission,
        ];

        array_push($this->links, $link);

        return $this;
    }

    public function getLinks()
    {
        return $this->links;
    }
}
