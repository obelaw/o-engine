<?php

namespace Obelaw\Schema;

class ModuleInfo
{
    private $info = [];

    public function info(string $name, string $icon, string $href, bool $helper = null)
    {
        $this->info = [
            'name' => $name,
            'icon' => $icon,
            'href' => $href,
            'helper' => $helper,
        ];
    }

    public function getInfo()
    {
        return $this->info;
    }
}
