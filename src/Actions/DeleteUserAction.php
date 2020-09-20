<?php


namespace Iyngaran\LaravelUser\Actions;

use Iyngaran\LaravelUser\Exceptions\UserNotFoundException;
use App\User;

class DeleteUserAction
{
    public function execute(int $id): bool
    {
        $user = $this->getUserModel()::find($id);
        if (!$user) {
            throw new UserNotFoundException("The user [" . $id . "] not found");
        }
        return $user->delete();
    }

    private function getUserModel()
    {
        return config('iyngaran.user.user_model');
    }
}
