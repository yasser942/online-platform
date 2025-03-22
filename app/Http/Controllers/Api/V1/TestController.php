<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TestResource;
use App\Http\Resources\V1\QuestionResource;
use App\Repositories\Interfaces\TestRepositoryInterface;
use App\Traits\V1\ApiResponse;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    use ApiResponse;
    
    protected $testRepository;

    public function __construct(TestRepositoryInterface $testRepository)
    {
        $this->testRepository = $testRepository;
    }

    /**
     * Display the specified test.
     */
    public function show(int $id): JsonResponse
    {
        $test = $this->testRepository->findById($id);

        if (!$test) {
            return $this->notFoundResponse('Test not found');
        }

        return $this->successResponse(new TestResource($test), 'Test retrieved successfully');
    }

    /**
     * Get questions for a specific test.
     */
    public function questions(int $testId): JsonResponse
    {
        $test = $this->testRepository->findById($testId);

        if (!$test) {
            return $this->notFoundResponse('Test not found');
        }

        $questions = $this->testRepository->getQuestionsByTestId($testId);
        
        return $this->successResponse(QuestionResource::collection($questions), 'Questions retrieved successfully');
    }
}
