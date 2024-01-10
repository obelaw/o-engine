<?php

namespace Obelaw\Schema;

class ModuleInfo
{
    private $info = [];

    public function info(string $name, string $icon, string $href, bool $helper = null, $group = null)
    {
        $this->info = [
            'name' => $name,
            'icon' => (file_exists(public_path($icon))) ? $icon : 'vendor/obelaw/images/default.svg',
            'href' => $href,
            'helper' => $helper,
            'group' => $group ?? 'erp',
        ];
    }

    public function getInfo()
    {
        return $this->info;
    }
}
