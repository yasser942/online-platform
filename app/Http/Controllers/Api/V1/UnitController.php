<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\LessonResource;
use App\Http\Resources\V1\UnitResource;
use App\Repositories\Interfaces\UnitRepositoryInterface;
use App\Traits\V1\ApiResponse;
use Illuminate\Http\JsonResponse;

class UnitController extends Controller
{
    use ApiResponse;

    public function __construct(
        private UnitRepositoryInterface $unitRepository
    ) {}

    public function show(int $id): JsonResponse
    {
        $unit = $this->unitRepository->findById($id);

        if (!$unit) {
            return $this->notFoundResponse('Unit not found');
        }

        return $this->successResponse(
            new UnitResource($unit),
            'Unit retrieved successfully'
        );
    }

    public function lessons(int $unitId): JsonResponse
    {
        $lessons = $this->unitRepository->getLessonsByUnitId($unitId);

        return $this->successResponse(
            LessonResource::collection($lessons),
            'Unit lessons retrieved successfully'
        );
    }
}
