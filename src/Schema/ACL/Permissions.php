<?php

namespace Obelaw\Schema\ACL;

class Permissions
{
    public $permissions = [];

    public function setPermission($label, $permission)
    {
        array_push($this->permissions, [
            'label' => $label,
            'permission' => $permission,
        ]);
    }

    public function getPermissions()
    {
        return $this->permissions;
    }
}
