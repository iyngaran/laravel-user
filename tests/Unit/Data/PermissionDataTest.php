<?php

namespace Iyngaran\LaravelUser\Tests\Unit\Data;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Iyngaran\LaravelUser\DTOs\PermissionData;
use Illuminate\Foundation\Testing\WithFaker;
use Iyngaran\LaravelUser\Tests\TestCase;
use Illuminate\Http\Request;

class PermissionDataTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testPermissionData()
    {
        $request = new Request(
            [
                "name" => $this->faker->word
            ]
        );
        $permissionData = PermissionData::fromRequest($request);
        $this->assertArrayHasKey('name', $permissionData);
    }
}
