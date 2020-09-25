<?php


namespace Iyngaran\LaravelUser\Actions;


use Iyngaran\LaravelUser\Models\UserProfile;

class CreateUserAction
{
    public function execute(array $attributes)
    {
        $user = $this->getUserModel()::create(
            [
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'password' => $attributes['password'],
            ]
        );

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
        $user->assignRole($attributes['roles']);
        $user->givePermissionTo($attributes['extraPermissions']);
        if (isset($attributes['passwordChangeAt']) && $attributes['passwordChangeAt'] != "") {
            $user->update(['password_change_at' => $attributes['passwordChangeAt']]);
        }
        $user->sendEmailVerificationNotification();
        return $user;
    }

    private function getUserModel()
    {
        return config('iyngaran.user.user_model');
    }
}
