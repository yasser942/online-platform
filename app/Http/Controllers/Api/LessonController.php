<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InteractiveResource;
use App\Http\Resources\LessonResource;
use App\Http\Resources\PdfResource;
use App\Http\Resources\TestResource;
use App\Http\Resources\VideoResource;
use App\Repositories\Interfaces\LessonRepositoryInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class LessonController extends Controller
{
    use ApiResponse;

    public function __construct(
        private LessonRepositoryInterface $lessonRepository
    ) {
    }

    public function show(int $id): JsonResponse
    {
        $lesson = $this->lessonRepository->findById($id);

        if (!$lesson) {
            return $this->notFoundResponse('Lesson not found');
        }

        return $this->successResponse(
            new LessonResource($lesson),
            'Lesson retrieved successfully'
        );
    }

    public function videos(int $lessonId): JsonResponse
    {
        $videos = $this->lessonRepository->getVideos($lessonId);
        return $this->successResponse(
            VideoResource::collection($videos),
            'Lesson videos retrieved successfully'
        );
    }

    public function pdfs(int $lessonId): JsonResponse
    {
        $pdfs = $this->lessonRepository->getPDFs($lessonId);
        return $this->successResponse(
            PdfResource::collection($pdfs),
            'Lesson PDFs retrieved successfully'
        );
    }

    public function tests(int $lessonId): JsonResponse
    {
        $tests = $this->lessonRepository->getTests($lessonId);
        return $this->successResponse(
            TestResource::collection($tests),
            'Lesson tests retrieved successfully'
        );
    }

    public function interactives(int $lessonId): JsonResponse
    {
        $interactives = $this->lessonRepository->getInteractives($lessonId);
        return $this->successResponse(
            InteractiveResource::collection($interactives),
            'Lesson interactives retrieved successfully'
        );
    }
}
