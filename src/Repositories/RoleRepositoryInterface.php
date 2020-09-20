<?php


namespace Iyngaran\LaravelUser\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface
{
    public function find(int $id): ?Role;

    public function findByName(string $name): ?Role;

    public function all(): ?Collection;

}
