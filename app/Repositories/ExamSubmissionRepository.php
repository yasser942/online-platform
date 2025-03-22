<?php

namespace App\Repositories;

use App\Models\ExamSubmission;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\ExamSubmissionRepositoryInterface;

class ExamSubmissionRepository implements ExamSubmissionRepositoryInterface
{
    public function findById(int $id): ?ExamSubmission
    {
        return ExamSubmission::find($id);
    }

    public function getSubmissionsByUserId(int $userId): Collection
    {
        return ExamSubmission::where('user_id', $userId)
            ->with(['exam'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getSubmissionsByExamId(int $examId): Collection
    {
        return ExamSubmission::where('exam_id', $examId)
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function createSubmission(array $data): ExamSubmission
    {
        return ExamSubmission::create($data);
    }

    public function updateSubmission(int $id, array $data): ?ExamSubmission
    {
        $submission = $this->findById($id);
        
        if (!$submission) {
            return null;
        }
        
        $submission->update($data);
        return $submission->fresh();
    }
}
