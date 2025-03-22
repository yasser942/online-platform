<?php

namespace App\Repositories\Interfaces;

use App\Models\ExamSubmission;
use Illuminate\Database\Eloquent\Collection;

interface ExamSubmissionRepositoryInterface
{
    public function findById(int $id): ?ExamSubmission;
    public function getSubmissionsByUserId(int $userId): Collection;
    public function getSubmissionsByExamId(int $examId): Collection;
    public function createSubmission(array $data): ExamSubmission;
    public function updateSubmission(int $id, array $data): ?ExamSubmission;
}
