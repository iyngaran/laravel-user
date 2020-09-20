<?php


namespace Iyngaran\LaravelUser\Tests;

use Iyngaran\LaravelUser\LaravelUserServiceProvider;
use Spatie\Permission\PermissionServiceProvider;
use Laravel\Sanctum\SanctumServiceProvider;
use Illuminate\Support\Facades\Config;


class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::set('auth.defaults.guard', 'web');
        $this->setUpDatabase();
    }

    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            PermissionServiceProvider::class,
            LaravelUserServiceProvider::class,
            SanctumServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app['config']->set('database.default', 'testdb');
        $app['config']->set(
            'database.connections.testdb',
            [
                'driver' => 'sqlite',
                'database' => ':memory:'
            ]
        );
        $app['config']->set('mail.driver', 'log');
    }


    private function setUpDatabase(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/resources/database/migrations');
    }
}
