<?php


namespace Iyngaran\LaravelUser\Repositories;


use Iyngaran\LaravelUser\Exceptions\UserNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use App\User;

class UserRepository implements UserRepositoryInterface
{

    public function find(int $id)
    {
        $user = $this->getUserModel()::find($id);
        if (!$user) {
            throw new UserNotFoundException("The user [" . $id . "] not found");
        }
        return $user;
    }

    public function findByEmail(string $email)
    {
        $user = $this->getUserModel()::where('email', $email)->first();
        if (!$user) {
            throw new UserNotFoundException("The user [" . $email . "] not found");
        }
        return $user;
    }

    public function all(): ?Collection
    {
        return $this->getUserModel()::all();
    }

    public function findWithRolesAndPermissions(int $id)
    {
        $user = $this->getUserModel()::with('roles', 'permissions')->find($id);
        if (!$user) {
            throw new UserNotFoundException("The user [" . $id . "] not found");
        }
        return $user;
    }

    private function getUserModel()
    {
        return config('iyngaran.user.user_model');
    }
}
