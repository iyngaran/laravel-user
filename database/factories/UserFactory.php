<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Iyngaran\LaravelUser\Models\UserProfile;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(
    \Iyngaran\LaravelUser\Tests\Models\User::class,
    function (Faker $faker) {
        return [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => 'password',
            'remember_token' => Str::random(10),
            'password_change_at' => now(),
        ];
    }
);

$factory->afterCreating(
    \Iyngaran\LaravelUser\Tests\Models\User::class,
    function ($row, $faker) {
        $userProfile = new UserProfile(
            [
                'companyName' => $this->faker->company,
                'address' => $this->faker->address,
                'mobile' => $this->faker->phoneNumber,
                'phone' => $this->faker->phoneNumber,
                'fb' => $this->faker->url,
                'in' => $this->faker->url,
                'locationLat' => $this->faker->latitude,
                'locationLon' => $this->faker->longitude,
                'logo' => 'logo.png'
            ]
        );
        $userProfile->user()->associate($row)->save();
        $roles = factory(Role::class, 3)->create();
        $permissions = factory(Permission::class, 5)->create();
        $row->assignRole($roles);
        $row->givePermissionTo($permissions); // extra permissions
    }
);
