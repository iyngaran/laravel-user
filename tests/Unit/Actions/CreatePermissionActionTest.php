<?php


namespace Iyngaran\LaravelUser\Tests\Unit\Actions;


use Iyngaran\LaravelUser\Actions\CreatePermissionAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Iyngaran\LaravelUser\Tests\TestCase;
use Spatie\Permission\Models\Permission;

class CreatePermissionActionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testCreatePermissionActionTest()
    {
        $attributes = [
            'name' => $this->faker->word
        ];
        $permission = (new CreatePermissionAction())->execute($attributes);
        $this->assertNotNull($permission->id);
        $this->assertEquals(1, Permission::count());
    }
}
