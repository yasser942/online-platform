<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\LevelController;
use App\Http\Controllers\Api\V1\UnitController;
use App\Http\Controllers\Api\V1\LessonController;

/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for version 1 of your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// Public routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
    });
    
    // User route
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Course routes
    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index']);
        Route::get('/{id}', [CourseController::class, 'show']);
        Route::get('/{courseId}/levels', [CourseController::class, 'levels']);
    });
    
    // Level routes
    Route::prefix('levels')->group(function () {
        Route::get('/{id}', [LevelController::class, 'show']);
        Route::get('/{levelId}/units', [LevelController::class, 'units']);
        Route::get('/{levelId}/exams', [LevelController::class, 'exams']);
    });
    
    // Unit routes
    Route::prefix('units')->group(function () {
        Route::get('/{id}', [UnitController::class, 'show']);
        Route::get('/{unitId}/lessons', [UnitController::class, 'lessons']);
    });
    
    // Lesson routes
    Route::prefix('lessons')->group(function () {
        Route::get('/{id}', [LessonController::class, 'show']);
        Route::get('/{lessonId}/videos', [LessonController::class, 'videos']);
        Route::get('/{lessonId}/pdfs', [LessonController::class, 'pdfs']);
        Route::get('/{lessonId}/tests', [LessonController::class, 'tests']);
        Route::get('/{lessonId}/interactives', [LessonController::class, 'interactives']);
    });
});