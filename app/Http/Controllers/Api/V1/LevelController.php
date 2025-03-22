<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ExamResource;
use App\Http\Resources\V1\LevelResource;
use App\Http\Resources\V1\UnitResource;
use App\Repositories\Interfaces\LevelRepositoryInterface;
use App\Traits\V1\ApiResponse;
use Illuminate\Http\JsonResponse;

class LevelController extends Controller
{
    use ApiResponse;

    /**
     * @var LevelRepositoryInterface
     */
    protected $levelRepository;

    /**
     * LevelController constructor
     * 
     * @param LevelRepositoryInterface $levelRepository
     */
    public function __construct(LevelRepositoryInterface $levelRepository)
    {
        $this->levelRepository = $levelRepository;
    }

    /**
     * Get a specific level by ID
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $level = $this->levelRepository->findById($id);
        
        if (!$level) {
            return $this->notFoundResponse('Level not found');
        }
        
        return $this->successResponse(
            new LevelResource($level),
            'Level retrieved successfully'
        );
    }

    /**
     * Get units for a specific level
     * 
     * @param int $levelId
     * @return JsonResponse
     */
    public function units(int $levelId): JsonResponse
    {
        $level = $this->levelRepository->findById($levelId);
        
        if (!$level) {
            return $this->notFoundResponse('Level not found');
        }
        
        $units = $this->levelRepository->getUnitsByLevelId($levelId);
        
        return $this->successResponse(
            UnitResource::collection($units),
            'Level units retrieved successfully'
        );
    }

    /**
     * Get exams for a specific level
     * 
     * @param int $levelId
     * @return JsonResponse
     */
    public function exams(int $levelId): JsonResponse
    {
        $level = $this->levelRepository->findById($levelId);
        
        if (!$level) {
            return $this->notFoundResponse('Level not found');
        }
        
        $exams = $this->levelRepository->getExamsByLevelId($levelId);
        
        return $this->successResponse(
            ExamResource::collection($exams),
            'Level exams retrieved successfully'
        );
    }
}
