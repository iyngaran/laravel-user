<?php


namespace Iyngaran\LaravelUser\Repositories;

use Iyngaran\LaravelUser\Exceptions\RoleNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;


class RoleRepository implements RoleRepositoryInterface
{

    public function find(int $id): Role
    {
        $role = Role::find($id);
        if (!$role) {
            throw new RoleNotFoundException("The role [" . $id . "] does not exist");
        }
        return $role;
    }

    public function findByName(string $name): Role
    {
        $role = Role::where('name', $name)->first();
        if (!$role) {
            throw new RoleNotFoundException("The role [" . $name . "] does not exist");
        }
        return $role;
    }

    public function all(): Collection
    {
        return Role::all();
    }
}
