<?php

namespace App\Repositories;

use App\Enums\Status;
use App\Models\Lesson;
use App\Repositories\Interfaces\LessonRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class LessonRepository implements LessonRepositoryInterface
{
    public function findById(int $id): ?Lesson
    {
        return Lesson::find($id);
    }

    public function getVideos(int $lessonId): Collection
    {
        return Lesson::findOrFail($lessonId)
            ->videos()
            ->where('status', Status::ACTIVE)
            ->get();
    }

    public function getPDFs(int $lessonId): Collection
    {
        return Lesson::findOrFail($lessonId)
            ->pdfs()
            ->where('status', Status::ACTIVE)
            ->get();
    }

    public function getTests(int $lessonId): Collection
    {
        return Lesson::findOrFail($lessonId)
            ->tests()
            ->where('status', Status::ACTIVE)
            ->get();
    }

    public function getInteractives(int $lessonId): Collection
    {
        return Lesson::findOrFail($lessonId)
            ->interactives()
            ->where('status', Status::ACTIVE)
            ->get();
    }
}
