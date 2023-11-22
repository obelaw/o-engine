<?php

namespace Obelaw\Schema\ACL;

class Section
{
    public $sections = [];

    public function setSection($label, $permission, $permissions)
    {
        $permissionsClass = new Permissions;

        $permissions($permissionsClass);

        array_push($this->sections, [
            'label' => $label,
            'permission' => $permission,
            'permissions' => $permissionsClass->getPermissions(),
        ]);
    }

    public function getSection()
    {
        return $this->sections;
    }
}
