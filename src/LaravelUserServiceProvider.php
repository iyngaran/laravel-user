<?php

namespace Iyngaran\LaravelUser;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Iyngaran\LaravelUser\Repositories\PermissionRepository;
use Iyngaran\LaravelUser\Repositories\PermissionRepositoryInterface;
use Iyngaran\LaravelUser\Repositories\RoleRepository;
use Iyngaran\LaravelUser\Repositories\RoleRepositoryInterface;
use Iyngaran\LaravelUser\Repositories\UserRepository;
use Iyngaran\LaravelUser\Repositories\UserRepositoryInterface;

class LaravelUserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/iyngaran.user.php' => config_path('iyngaran.user.php'),
            ], 'user-config');
        }
        $this->registerResources();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/iyngaran.user.php', 'iyngaran.user');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-user', function () {
            return new LaravelUser;
        });
        $this->registerRepositories();
        $this->commands(
            [
                Console\CreateUserCommand::class
            ]
        );
    }


    private function registerResources()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadFactoriesFrom(__DIR__ . '/../database/factories');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'iyngaran.categories');

        $this->registerWebRoutes();
        $this->registerApiRoutes();
    }


    private function registerWebRoutes()
    {
        Route::group(
            $this->webRouteConfiguration(),
            function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
            }
        );
    }

    private function registerApiRoutes()
    {
        Route::group(
            $this->apiRouteConfiguration(),
            function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
            }
        );
    }

    private function webRouteConfiguration()
    {
        return  [
            'prefix' => "/",
            'middleware' => "web",
            'namespace' => 'Iyngaran\LaravelUser\Http\Controllers'
        ];
    }

    private function apiRouteConfiguration()
    {
        return  [
            'prefix' => 'api/',
            'middleware' => "api",
            'namespace' => 'Iyngaran\LaravelUser\Http\Controllers\Api'

        ];
    }

    private function registerRepositories()
    {
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
