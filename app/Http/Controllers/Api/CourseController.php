<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\LevelResource;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    use ApiResponse;

    /**
     * @var CourseRepositoryInterface
     */
    protected $courseRepository;

    /**
     * CourseController constructor
     * 
     * @param CourseRepositoryInterface $courseRepository
     */
    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * Get all active courses
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $courses = $this->courseRepository->getAllActive();
        
        return $this->successResponse(
            CourseResource::collection($courses),
            'Courses retrieved successfully'
        );
    }

    /**
     * Get a specific course by ID
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $course = $this->courseRepository->findById($id);
        
        if (!$course) {
            return $this->notFoundResponse('Course not found');
        }
        
        return $this->successResponse(
            new CourseResource($course),
            'Course retrieved successfully'
        );
    }

    /**
     * Get levels for a specific course
     * 
     * @param int $courseId
     * @return JsonResponse
     */
    public function levels(int $courseId): JsonResponse
    {
        $course = $this->courseRepository->findById($courseId);
        
        if (!$course) {
            return $this->notFoundResponse('Course not found');
        }
        
        $levels = $this->courseRepository->getLevelsByCourseId($courseId);
        
        return $this->successResponse(
            LevelResource::collection($levels),
            'Course levels retrieved successfully'
        );
    }
}
