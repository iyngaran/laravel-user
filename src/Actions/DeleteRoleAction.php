<?php


namespace Iyngaran\LaravelUser\Actions;


use Iyngaran\LaravelUser\Exceptions\RoleNotFoundException;
use Spatie\Permission\Models\Role;

class DeleteRoleAction
{
    public function execute(int $roleId): bool
    {
        $role = Role::find($roleId);
        if (!$role) {
            throw new RoleNotFoundException("The Role [" . $roleId . "] does not exist.");
        }
        (new RevokePermissionsAction())->execute($role);
        return $role->delete();
    }
}
