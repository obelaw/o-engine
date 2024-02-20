<?php

namespace Obelaw\Schema\Navbar;

class SubLinks
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

    public function thirdLinks($icon, $label, $links, $id = null, $permission = null, $position = 999)
    {
        $third = new ThirdSubLinks;

        $links($third);

        $_links = [
            'id' => $id,
            'icon' => $icon,
            'label' => $label,
            'permission' => $permission,
            'thirdlinks' => $third->getLinks(),
            'position' => $position,
        ];

        $_links['icon'] = (file_exists(public_path($_links['icon']))) ? $_links['icon'] : 'vendor/obelaw/images/default.svg';


        array_push($this->links, $_links);

        return $this;
    }

    public function getLinks()
    {
        return $this->links;
    }
}
