<?php


namespace Iyngaran\LaravelUser\Actions;

use Spatie\Permission\Models\Role;

class CreateRoleAction
{
    public function execute(array $attributes): Role
    {
        $role = Role::create(
            [
                'name' => $attributes['name'],
                'guard_name' => 'api'
            ]
        );

        if ($role && isset($attributes['permissions'])) {
            $role = (new AttachPermissionsAction())->execute($role, $attributes['permissions']);
        }

        return $role;
    }
}
