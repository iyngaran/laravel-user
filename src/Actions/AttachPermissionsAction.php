<?php


namespace Iyngaran\LaravelUser\Actions;


use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class AttachPermissionsAction
{
    public function execute(Role $role, Collection $permissions): Role
    {
        $role->syncPermissions($permissions);
        return $role;
    }
}
