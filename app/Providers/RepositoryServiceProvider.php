<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Repositories\LevelRepository;
use App\Repositories\CourseRepository;
use App\Repositories\UnitRepository;
use App\Repositories\LessonRepository;
use App\Repositories\ExamRepository;
use App\Repositories\TestRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\UnitRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\LevelRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\LessonRepositoryInterface;
use App\Repositories\Interfaces\ExamRepositoryInterface;
use App\Repositories\Interfaces\TestRepositoryInterface;

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
        
        $this->app->bind(
            LessonRepositoryInterface::class,
            LessonRepository::class
        );
        
        $this->app->bind(
            ExamRepositoryInterface::class,
            ExamRepository::class
        );
        
        $this->app->bind(
            TestRepositoryInterface::class,
            TestRepository::class
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
