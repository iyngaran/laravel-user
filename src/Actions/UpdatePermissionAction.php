<?php


namespace Iyngaran\LaravelUser\Actions;


use Iyngaran\LaravelUser\Exceptions\PermissionNotFoundException;
use Spatie\Permission\Models\Permission;

class UpdatePermissionAction
{
    public function execute(array $attributes, int $id): Permission
    {
        $permission = Permission::find($id);
        if (!$permission) {
            throw new PermissionNotFoundException("The Permission id # " . $id . " not found");
        }

        $permission->update(
            [
                'name' => $attributes['name']
            ]
        );
        return $permission;
    }
}
