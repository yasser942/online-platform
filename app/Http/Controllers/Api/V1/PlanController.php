<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PlanResource;
use App\Repositories\Interfaces\PlanRepositoryInterface;
use App\Traits\V1\ApiResponse;
use Illuminate\Http\JsonResponse;

class PlanController extends Controller
{
    use ApiResponse;
    
    protected $planRepository;

    public function __construct(PlanRepositoryInterface $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    /**
     * Display a listing of active plans.
     */
    public function index(): JsonResponse
    {
        $plans = $this->planRepository->getAllActive();
        
        return $this->successResponse(
            PlanResource::collection($plans), 
            'Plans retrieved successfully'
        );
    }

    /**
     * Display the specified plan.
     */
    public function show(int $id): JsonResponse
    {
        $plan = $this->planRepository->findById($id);

        if (!$plan) {
            return $this->notFoundResponse('Plan not found');
        }

        return $this->successResponse(
            new PlanResource($plan), 
            'Plan retrieved successfully'
        );
    }
}
