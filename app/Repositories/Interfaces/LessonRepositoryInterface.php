<?php

namespace App\Repositories\Interfaces;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Collection;

interface LessonRepositoryInterface
{
    public function findById(int $id): ?Lesson;
    public function getVideos(int $lessonId): Collection;
    public function getPDFs(int $lessonId): Collection;
    public function getTests(int $lessonId): Collection;
    public function getInteractives(int $lessonId): Collection;
}
