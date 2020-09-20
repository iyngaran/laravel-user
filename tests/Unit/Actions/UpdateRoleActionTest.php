<?php

namespace Iyngaran\LaravelUser\Tests\Unit\Actions;

use Iyngaran\LaravelUser\Actions\UpdateRoleAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Iyngaran\LaravelUser\Tests\TestCase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UpdateRoleActionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testUpdateRoleActionTest()
    {
        $role = factory(Role::class)->create();
        $permissions = factory(Permission::class, 3)->create();
        $role = (new UpdateRoleAction())->execute(
            [
                'name' => $this->faker->word,
                'permissions' => $permissions
            ],
            $role->id
        );
        $this->assertNotNull($role->id);
        $this->assertEquals(3, $role->permissions()->count());
        $this->assertEquals(1, Role::count());
        $this->assertNotNull($role->permissions());
        $this->assertTrue($role->hasPermissionTo($permissions[0]->name));
    }
}
