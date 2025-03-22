<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\ProfileUpdateRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Http\Resources\V1\UserResource;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Traits\V1\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * AuthController constructor
     * 
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register a new user
     * 
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        // Create user using repository
        $user = $this->userRepository->create($request->validated());
        
        // Generate token for the user
        $token = $user->createToken('auth_token')->plainTextToken;
        
        // Return user data with token
        return $this->successResponse([
            'user' => new UserResource($user),
            'token' => $token
        ], 'User registered successfully');
    }
    
    /**
     * Login user
     * 
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            // Authenticate user (validation happens in LoginRequest)
            $request->authenticate();
            
            // Get authenticated user
            $user = Auth::user();
            
            // Generate token for the user
            $token = $user->createToken('auth_token')->plainTextToken;
            
            // Return user data with token
            return $this->successResponse([
                'user' => new UserResource($user),
                'token' => $token
            ], 'User logged in successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    
    /**
     * Logout user (revoke token)
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        // Revoke all tokens
        $request->user()->tokens()->delete();
        
        return $this->successResponse(null, 'User logged out successfully');
    }
    
    /**
     * Get authenticated user profile
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function profile(Request $request): JsonResponse
    {
        return $this->successResponse(
            new UserResource($request->user()),
            'User profile retrieved successfully'
        );
    }
    
    /**
     * Update user profile
     * 
     * @param ProfileUpdateRequest $request
     * @return JsonResponse
     */
    public function updateProfile(ProfileUpdateRequest $request): JsonResponse
    {
        // Update the user through repository
        $user = $this->userRepository->updateProfile(
            Auth::user(),
            $request->validated()
        );
        
        return $this->successResponse(
            new UserResource($user),
            'Profile updated successfully'
        );
    }
}
