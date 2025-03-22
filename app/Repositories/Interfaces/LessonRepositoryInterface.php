<?php

namespace App\Repositories\Interfaces;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Collection;

interface LessonRepositoryInterface
{
    public function findById(int $id): ?Lesson;
    public function getVideosByLessonId(int $lessonId): Collection;
    public function getPDFsByLessonId(int $lessonId): Collection;
    public function getTestsByLessonId(int $lessonId): Collection;
    public function getInteractivesByLessonId(int $lessonId): Collection;
}
