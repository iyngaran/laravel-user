<?php

namespace Iyngaran\LaravelUser\Tests\Unit\Actions;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Iyngaran\LaravelUser\Actions\DeleteRoleAction;
use Iyngaran\LaravelUser\Tests\TestCase;
use Spatie\Permission\Models\Role;

class DeleteRoleActionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testDeleteRoleActionTest()
    {
        $role = factory(Role::class)->create();
        $role = (new DeleteRoleAction())->execute($role->id);
        $this->assertEquals(0, Role::count());
        $this->assertTrue($role);
    }
}
