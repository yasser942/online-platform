<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Repositories\LevelRepository;
use App\Repositories\CourseRepository;
use App\Repositories\UnitRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\UnitRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\LevelRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            CourseRepositoryInterface::class,
            CourseRepository::class
        );

        $this->app->bind(
            LevelRepositoryInterface::class,
            LevelRepository::class
        );
        $this->app->bind(
            UnitRepositoryInterface::class,
            UnitRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
