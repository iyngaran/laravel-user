<?php


namespace Iyngaran\LaravelUser\Tests\Unit\Actions;


use Iyngaran\LaravelUser\Actions\DeletePermissionAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Iyngaran\LaravelUser\Tests\TestCase;
use Spatie\Permission\Models\Permission;

class DeletePermissionActionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testDeletePermissionAction()
    {
        $permission = factory(Permission::class)->create();
        $deletePermission = (new DeletePermissionAction())->execute($permission->id);
        $this->assertTrue($deletePermission);
        $this->assertEquals(0, Permission::count());
    }
}
