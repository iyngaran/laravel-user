<?php


namespace Iyngaran\LaravelUser\Actions;


use Iyngaran\LaravelUser\Exceptions\RoleNotFoundException;
use Spatie\Permission\Models\Role;

class UpdateRoleAction
{
    public function execute(array $attributes, int $roleId): Role
    {
        $role = Role::find($roleId);
        if (!$role) {
            throw new RoleNotFoundException("The Role [" . $roleId . "] does not exist.");
        }

        $role->update(
            [
                'name' => $attributes['name']
            ]
        );

        if ($role && isset($attributes['permissions'])) {
            $role = (new AttachPermissionsAction())->execute($role, $attributes['permissions']);
        }

        return $role;
    }
}
