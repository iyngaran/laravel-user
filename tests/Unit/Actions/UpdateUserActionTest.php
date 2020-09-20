<?php

namespace Iyngaran\LaravelUser\Tests\Unit\Actions;

use Iyngaran\LaravelUser\Actions\UpdateUserAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Iyngaran\LaravelUser\Tests\TestCase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UpdateUserActionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }


    public function testUpdateUserActionTest()
    {
        $factoryUser = factory($this->getUserModel())->create();
        $roles = factory(Role::class, 3)->create();
        $permissions = factory(Permission::class, 4)->create();

        $user = (new UpdateUserAction())->execute(
            [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'password' => $this->faker->password,
                'companyName' => $this->faker->company,
                'address' => $this->faker->address,
                'mobile' => $this->faker->phoneNumber,
                'phone' => $this->faker->phoneNumber,
                'fb' => $this->faker->url,
                'in' => $this->faker->url,
                'locationLat' => $this->faker->latitude,
                'locationLon' => $this->faker->longitude,
                'logo' => 'logo.png',
                'roles' => $roles,
                'extraPermissions' => $permissions
            ],
            $factoryUser->id
        );
        $this->assertNotNull($user->id);
        $this->assertEquals(1, $this->getUserModel()::count());
        $this->assertEquals(1, $user->profile->count());
        $this->assertEquals(1, $user->profile->count());
        $this->assertEquals(3, $user->roles()->count());
        $this->assertEquals(4, $user->getDirectPermissions()->count());
        $this->assertEquals($roles->pluck('name'), $user->getRoleNames());
        $this->assertEquals($permissions->pluck('name'), $user->getPermissionNames());
    }

    private function getUserModel()
    {
        return config('iyngaran.user.user_model');
    }
}
