<?php


namespace Iyngaran\LaravelUser\Repositories;


use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

interface PermissionRepositoryInterface
{
    public function find(int $id): ?Permission;

    public function findByName(string $name): ?Permission;

    public function all(): ?Collection;
}
