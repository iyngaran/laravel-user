<?php


namespace Iyngaran\LaravelUser\Actions;


use Iyngaran\LaravelUser\Exceptions\UserNotFoundException;
use Illuminate\Support\Carbon;
use App\User;


class ResetPasswordAction
{
    public function execute(array $attributes, int $userId): User
    {
        $user = User::find($userId);
        if (!$user) {
            throw new UserNotFoundException("The user [" . $userId . "] not found");
        }

        if ($attributes['password']) {
            $user->update(
                [
                    'password' => $attributes['password'],
                    'password_change_at' => Carbon::now(),
                ]
            );
        }
        return $user;
    }
}
