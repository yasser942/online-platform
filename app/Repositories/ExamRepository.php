<?php

namespace App\Repositories;

use App\Enums\Status;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\ExamRepositoryInterface;

class ExamRepository implements ExamRepositoryInterface
{
    public function findById(int $id): ?Exam
    {
        return Exam::where('id', $id)
            ->where('status', Status::ACTIVE)
            ->first();
    }

    public function getQuestionsByExamId(int $examId): Collection
    {
        return Question::where('questionable_type', Exam::class)
            ->where('questionable_id', $examId)
            ->with('choices')
            ->get();
    }

    public function getExamsByLevelId(int $levelId): Collection
    {
        return Exam::where('level_id', $levelId)
            ->where('status', Status::ACTIVE)
            ->get();
    }
}
