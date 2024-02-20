<?php

namespace Obelaw\Schema\Navbar;

class Links
{
    private $links = [];
    private $pushlinks = [];

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

    public function pushLink($to, $icon, $label, $href, $permission = null, $position = 999)
    {
        $link[$to] = [
            'icon' => $icon,
            'label' => $label,
            'href' => $href,
            'permission' => $permission,
            'position' => $position,
        ];

        $link[$to]['icon'] = (file_exists(public_path($link[$to]['icon']))) ? $link[$to]['icon'] : 'vendor/obelaw/images/default.svg';

        $this->pushlinks = array_merge($this->pushlinks, $link);

        return $this;
    }

    public function subLinks($icon, $label, $links, $id = null, $permission = null, $position = 999)
    {
        $sub = new SubLinks;

        $links($sub);

        $_links = [
            'id' => $id,
            'icon' => $icon,
            'label' => $label,
            'permission' => $permission,
            'sublinks' => $sub->getLinks(),
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

    public function getPushLink()
    {
        return $this->pushlinks;
    }
}
