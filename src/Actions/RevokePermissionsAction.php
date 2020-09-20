<?php


namespace Iyngaran\LaravelUser\Actions;


use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class RevokePermissionsAction
{
    public function execute(Role $role): Role
    {
        if ($role->permissions()) {
            $role->revokePermissionTo($role->getPermissionNames());
        }
        return $role;
    }
}
