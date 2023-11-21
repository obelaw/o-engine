<?php

namespace Obelaw\Schema;

class ModuleInfo
{
    private $info = [];

    public function info(string $name, string $icon, string $href)
    {
        $this->info = [
            'name' => $name,
            'icon' => $icon,
            'href' => $href,
        ];
    }

    public function getInfo()
    {
        return $this->info;
    }
}
