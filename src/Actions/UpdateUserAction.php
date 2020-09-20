<?php


namespace Iyngaran\LaravelUser\Actions;


use Iyngaran\LaravelUser\Exceptions\UserNotFoundException;
use App\User;
use Iyngaran\LaravelUser\Models\UserProfile;


class UpdateUserAction
{
    public function execute(array $attributes, int $userId)
    {
        $user = $this->getUserModel()::find($userId);
        if (!$user) {
            throw new UserNotFoundException("The user [" . $userId . "] not found");
        }

        $user->update(
            [
                'name' => $attributes['name']
            ]
        );

        if ($attributes['password']) {
            $user->update(
                [
                    'password' => $attributes['password'],
                ]
            );
        }

        if ($attributes['roles']) {
            $user->syncRoles($attributes['roles']);
        }

        if ($attributes['extraPermissions']) {
            $user->syncPermissions($attributes['extraPermissions']);
        }

        if (!$user->profile) {
            $userProfile = new UserProfile(
                [
                    'company_name' => $attributes['companyName'],
                    'address' => $attributes['address'],
                    'mobile' => $attributes['mobile'],
                    'phone' => $attributes['phone'],
                    'logo' => $attributes['logo'],
                    'fb' => $attributes['fb'],
                    'in' => $attributes['in'],
                    'location_lat' => $attributes['locationLat'],
                    'location_lon' => $attributes['locationLon'],
                ]
            );
            $userProfile->user()->associate($user)->save();
        } else {
            $userProfile = UserProfile::find($user->profile->id);
            $userProfile->update(
                [
                    'company_name' => $attributes['companyName'],
                    'address' => $attributes['address'],
                    'mobile' => $attributes['mobile'],
                    'phone' => $attributes['phone'],
                    'logo' => $attributes['logo'],
                    'fb' => $attributes['fb'],
                    'in' => $attributes['in'],
                    'location_lat' => $attributes['locationLat'],
                    'location_lon' => $attributes['locationLon'],
                ]
            );
        }


        return $user;
    }

    private function getUserModel()
    {
        return config('iyngaran.user.user_model');
    }
}
