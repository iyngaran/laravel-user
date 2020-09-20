<?php

namespace Iyngaran\LaravelUser\Tests\Unit\Data;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Iyngaran\LaravelUser\Tests\TestCase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Iyngaran\LaravelUser\DTOs\UserData;
use Illuminate\Http\Request;


class UserDataTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testUserData()
    {
        $roles = factory(Role::class, 3)->create();
        $permissions = factory(Permission::class, 3)->create();
        $role_ids = $roles->pluck('id');
        $permission_ids = $permissions->pluck('id');

        $request = new Request(
            [
                "name" => $this->faker->name,
                "email" => $this->faker->email,
                "password" => $this->faker->password,
                "company_name" => $this->faker->company,
                "address" => $this->faker->address,
                "mobile" => $this->faker->phoneNumber,
                "phone" => $this->faker->phoneNumber,
                "fb" => $this->faker->url,
                "in" => $this->faker->url,
                "location_lat" => $this->faker->latitude,
                "location_lon" => $this->faker->longitude,
                "logo" => "logo.png",
                "role_ids" => $role_ids,
                "exta_permission_ids" => $permission_ids,
            ]
        );
        $userData = UserData::fromRequest($request);
        $this->assertArrayHasKey('name', $userData);
        $this->assertArrayHasKey('email', $userData);
        $this->assertArrayHasKey('password', $userData);
        $this->assertArrayHasKey('roles', $userData);
        $this->assertArrayHasKey('extraPermissions', $userData);
    }
}
