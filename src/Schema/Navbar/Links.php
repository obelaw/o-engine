<?php

namespace Obelaw\Schema\Navbar;

class Links
{
    private $links = [];
    private $pushlinks = [];

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

    public function pushLink($to, $icon, $label, $href, $permission = null)
    {
        $link[$to] = [
            'icon' => $icon,
            'label' => $label,
            'href' => $href,
            'permission' => $permission,
        ];

        $this->pushlinks = array_merge($this->pushlinks, $link);

        return $this;
    }

    public function subLinks($icon, $label, $links, $id = null, $permission = null)
    {
        $sub = new SubLinks;

        $links($sub);

        $_links = [
            'id' => $id,
            'icon' => $icon,
            'label' => $label,
            'permission' => $permission,
            'sublinks' => $sub->getLinks(),
        ];

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
