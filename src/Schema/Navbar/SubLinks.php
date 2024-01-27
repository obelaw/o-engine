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

        $link['icon'] = (file_exists(public_path($link['icon']))) ? $link['icon'] : 'vendor/obelaw/images/default.svg';

        array_push($this->links, $link);

        return $this;
    }

    public function thirdLinks($icon, $label, $links, $id = null, $permission = null)
    {
        $third = new ThirdSubLinks;

        $links($third);

        $_links = [
            'id' => $id,
            'icon' => $icon,
            'label' => $label,
            'permission' => $permission,
            'thirdlinks' => $third->getLinks(),
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
