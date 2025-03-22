<?php

namespace App\Repositories;

use App\Enums\Status;
use App\Models\Test;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\TestRepositoryInterface;

class TestRepository implements TestRepositoryInterface
{
    public function findById(int $id): ?Test
    {
        return Test::where('id', $id)
            ->where('status', Status::ACTIVE)
            ->first();
    }

    public function getQuestionsByTestId(int $testId): Collection
    {
        return Question::where('questionable_type', Test::class)
            ->where('questionable_id', $testId)
            ->with('choices')
            ->get();
    }

    public function getTestsByLessonId(int $lessonId): Collection
    {
        return Test::where('lesson_id', $lessonId)
            ->where('status', Status::ACTIVE)
            ->get();
    }
}
