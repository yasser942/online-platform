<?php

namespace App\Providers;

use App\Repositories\CourseRepository;
use App\Repositories\LevelRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\LevelRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
