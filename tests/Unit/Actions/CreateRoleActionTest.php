<?php

namespace Iyngaran\LaravelUser\Tests\Unit\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Iyngaran\LaravelUser\Actions\CreateRoleAction;
use Illuminate\Foundation\Testing\WithFaker;
use Iyngaran\LaravelUser\Tests\TestCase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRoleActionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateRoleActionTest()
    {
        $permissions = factory(Permission::class, 3)->create();
        $role = (new CreateRoleAction())->execute(
            [
                'name' => $this->faker->word,
                'permissions' => $permissions
            ]
        );
        $this->assertNotNull($role->id);
        $this->assertEquals(1, Role::count());
        $this->assertNotNull($role->permissions());
        $this->assertTrue($role->hasPermissionTo($permissions[0]->name));
    }
}
