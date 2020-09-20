<?php

namespace Iyngaran\LaravelUser\Tests\Unit\Repository;


use Iyngaran\LaravelUser\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Iyngaran\LaravelUser\Tests\TestCase;

class RetrieveUsersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testRetrieveUserById()
    {
        $factUser = factory($this->getUserModel())->create();
        factory($this->getUserModel(), 3)->create();
        $userRepository = $this->app->make(UserRepositoryInterface::class);
        $user = $userRepository->find($factUser->id);
        $this->assertEquals($factUser->id, $user->id);
        $this->assertEquals($factUser->name, $user->name);
    }

    public function testRetrieveUserByEmail()
    {
        $factUser = factory($this->getUserModel())->create();
        factory($this->getUserModel(), 3)->create();
        $userRepository = $this->app->make(UserRepositoryInterface::class);
        $user = $userRepository->findByEmail($factUser->email);
        $this->assertEquals($factUser->id, $user->id);
        $this->assertEquals($factUser->name, $user->name);
    }

    public function testRetrieveUsers()
    {
        factory($this->getUserModel(), 5)->create();
        $userRepository = $this->app->make(UserRepositoryInterface::class);
        $users = $userRepository->all();
        $this->assertEquals(5, $users->count());
        $this->assertInstanceOf(Collection::class, $users);
    }

    private function getUserModel()
    {
        return config('iyngaran.user.user_model');
    }

}
