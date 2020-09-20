<?php


namespace Iyngaran\LaravelUser\Repositories;


use App\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function find(int $id);

    public function findWithRolesAndPermissions(int $id);

    public function findByEmail(string $name);

    public function all(): ?Collection;
}
