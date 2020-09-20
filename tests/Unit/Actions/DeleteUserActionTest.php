<?php

namespace Iyngaran\LaravelUser\Tests\Unit\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Iyngaran\LaravelUser\Actions\DeleteUserAction;
use Iyngaran\LaravelUser\Tests\TestCase;

class DeleteUserActionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testDeleteUserActionTest()
    {
        $user = factory($this->getUserModel())->create();
        $res = (new DeleteUserAction())->execute($user->id);
        $this->assertEquals(0, $this->getUserModel()::count());
        $this->assertTrue($res);
    }

    private function getUserModel()
    {
        return config('iyngaran.user.user_model');
    }
}
