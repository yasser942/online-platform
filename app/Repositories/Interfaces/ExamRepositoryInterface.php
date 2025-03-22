<?php

namespace App\Repositories\Interfaces;

use App\Models\Exam;
use Illuminate\Database\Eloquent\Collection;

interface ExamRepositoryInterface
{
    public function findById(int $id): ?Exam;
    public function getQuestionsByExamId(int $examId): Collection;
    public function getExamsByLevelId(int $levelId): Collection;
}
