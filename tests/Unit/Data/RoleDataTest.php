<?php

namespace Iyngaran\LaravelUser\Tests\Unit\Data;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Iyngaran\LaravelUser\Tests\TestCase;
use Spatie\Permission\Models\Permission;
use Iyngaran\LaravelUser\DTOs\RoleData;
use Illuminate\Http\Request;


class RoleDataTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }


    public function testRoleData()
    {
        $permissions = factory(Permission::class, 3)->create();
        $permission_ids = $permissions->pluck('id');
        $request = new Request(
            [
                "name" => $this->faker->word,
                "permission_ids" => $permission_ids
            ]
        );
        $roleData = RoleData::fromRequest($request);
        $this->assertArrayHasKey('name', $roleData);
        $this->assertArrayHasKey('permissions', $roleData);
    }
}
