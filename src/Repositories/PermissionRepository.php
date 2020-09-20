<?php


namespace Iyngaran\LaravelUser\Repositories;

use Iyngaran\LaravelUser\Exceptions\PermissionNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{

    public function find(int $id): Permission
    {
        $permission = Permission::find($id);
        if (!$permission) {
            throw new PermissionNotFoundException("The Permission id # " . $id . " not found");
        }
        return $permission;
    }

    public function findByName(string $name): Permission
    {
        $permission = Permission::where('name', $name)->first();
        if (!$permission) {
            throw new PermissionNotFoundException("The Permission name # " . $name . " not found");
        }
        return $permission;
    }

    public function all(): Collection
    {
        return Permission::all();
    }
}
