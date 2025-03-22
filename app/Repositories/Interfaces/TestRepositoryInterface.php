<?php

namespace App\Repositories\Interfaces;

use App\Models\Test;
use Illuminate\Database\Eloquent\Collection;

interface TestRepositoryInterface
{
    public function findById(int $id): ?Test;
    public function getQuestionsByTestId(int $testId): Collection;
    public function getTestsByLessonId(int $lessonId): Collection;
}
