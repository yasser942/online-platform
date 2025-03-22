<?php

namespace App\Repositories;

use App\Enums\Status;
use App\Models\Lesson;
use App\Models\Video;
use App\Models\PDF;
use App\Models\Test;
use App\Models\Interactive;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\LessonRepositoryInterface;

class LessonRepository implements LessonRepositoryInterface
{
    public function findById(int $id): ?Lesson
    {
        return Lesson::where('id', $id)
            ->where('status', Status::ACTIVE)
            ->first();
    }

    public function getVideosByLessonId(int $lessonId): Collection
    {
        return Video::where('lesson_id', $lessonId)
            ->where('status', Status::ACTIVE)
            ->get();
    }

    public function getPDFsByLessonId(int $lessonId): Collection
    {
        return PDF::where('lesson_id', $lessonId)
            ->where('status', Status::ACTIVE)
            ->get();
    }

    public function getTestsByLessonId(int $lessonId): Collection
    {
        return Test::where('lesson_id', $lessonId)
            ->where('status', Status::ACTIVE)
            ->get();
    }

    public function getInteractivesByLessonId(int $lessonId): Collection
    {
        return Interactive::where('lesson_id', $lessonId)
            ->where('status', Status::ACTIVE)
            ->get();
    }
}
