<?php


namespace Iyngaran\LaravelUser\Actions;


use Iyngaran\LaravelUser\Exceptions\UserNotFoundException;
use App\User;

class VerifyUserAction
{
    public function execute($user): bool
    {
        if (!$user) {
            throw new UserNotFoundException("The user does not exists");
        }
        return $user->markEmailAsVerified();
    }


}
