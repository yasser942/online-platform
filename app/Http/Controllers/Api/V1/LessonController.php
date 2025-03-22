<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\LessonResource;
use App\Http\Resources\V1\VideoResource;
use App\Http\Resources\V1\PDFResource;
use App\Http\Resources\V1\TestResource;
use App\Http\Resources\V1\InteractiveResource;
use App\Repositories\Interfaces\LessonRepositoryInterface;
use App\Traits\V1\ApiResponse;
use Illuminate\Http\JsonResponse;

class LessonController extends Controller
{
    use ApiResponse;
    
    protected $lessonRepository;

    public function __construct(LessonRepositoryInterface $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }

    /**
     * Display the specified lesson.
     */
    public function show(int $id): JsonResponse
    {
        $lesson = $this->lessonRepository->findById($id);

        if (!$lesson) {
            return $this->notFoundResponse('Lesson not found');
        }

        return $this->successResponse(new LessonResource($lesson), 'Lesson retrieved successfully');
    }

    /**
     * Get videos for a specific lesson.
     */
    public function videos(int $lessonId): JsonResponse
    {
        $lesson = $this->lessonRepository->findById($lessonId);

        if (!$lesson) {
            return $this->notFoundResponse('Lesson not found');
        }

        $videos = $this->lessonRepository->getVideosByLessonId($lessonId);
        
        return $this->successResponse(VideoResource::collection($videos), 'Videos retrieved successfully');
    }

    /**
     * Get PDFs for a specific lesson.
     */
    public function pdfs(int $lessonId): JsonResponse
    {
        $lesson = $this->lessonRepository->findById($lessonId);

        if (!$lesson) {
            return $this->notFoundResponse('Lesson not found');
        }

        $pdfs = $this->lessonRepository->getPDFsByLessonId($lessonId);
        
        return $this->successResponse(PDFResource::collection($pdfs), 'PDFs retrieved successfully');
    }

    /**
     * Get tests for a specific lesson.
     */
    public function tests(int $lessonId): JsonResponse
    {
        $lesson = $this->lessonRepository->findById($lessonId);

        if (!$lesson) {
            return $this->notFoundResponse('Lesson not found');
        }

        $tests = $this->lessonRepository->getTestsByLessonId($lessonId);
        
        return $this->successResponse(TestResource::collection($tests), 'Tests retrieved successfully');
    }

    /**
     * Get interactives for a specific lesson.
     */
    public function interactives(int $lessonId): JsonResponse
    {
        $lesson = $this->lessonRepository->findById($lessonId);

        if (!$lesson) {
            return $this->notFoundResponse('Lesson not found');
        }

        $interactives = $this->lessonRepository->getInteractivesByLessonId($lessonId);
        
        return $this->successResponse(InteractiveResource::collection($interactives), 'Interactives retrieved successfully');
    }
}
