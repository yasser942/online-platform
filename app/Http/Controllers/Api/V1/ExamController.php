<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ExamResource;
use App\Http\Resources\V1\QuestionResource;
use App\Repositories\Interfaces\ExamRepositoryInterface;
use App\Traits\V1\ApiResponse;
use Illuminate\Http\JsonResponse;

class ExamController extends Controller
{
    use ApiResponse;
    
    protected $examRepository;

    public function __construct(ExamRepositoryInterface $examRepository)
    {
        $this->examRepository = $examRepository;
    }

    /**
     * Display the specified exam.
     */
    public function show(int $id): JsonResponse
    {
        $exam = $this->examRepository->findById($id);

        if (!$exam) {
            return $this->notFoundResponse('Exam not found');
        }

        return $this->successResponse(new ExamResource($exam), 'Exam retrieved successfully');
    }

    /**
     * Get questions for a specific exam.
     */
    public function questions(int $examId): JsonResponse
    {
        $exam = $this->examRepository->findById($examId);

        if (!$exam) {
            return $this->notFoundResponse('Exam not found');
        }

        $questions = $this->examRepository->getQuestionsByExamId($examId);
        
        return $this->successResponse(QuestionResource::collection($questions), 'Questions retrieved successfully');
    }
}
