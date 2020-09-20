<?php

namespace Iyngaran\LaravelUser;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Iyngaran\LaravelUser\Skeleton\SkeletonClass
 */
class LaravelUserFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-user';
    }
}
