<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ExamSubmissionResource;
use App\Repositories\Interfaces\ExamRepositoryInterface;
use App\Repositories\Interfaces\ExamSubmissionRepositoryInterface;
use App\Traits\V1\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExamSubmissionController extends Controller
{
    use ApiResponse;
    
    protected $examSubmissionRepository;
    protected $examRepository;

    public function __construct(
        ExamSubmissionRepositoryInterface $examSubmissionRepository,
        ExamRepositoryInterface $examRepository
    ) {
        $this->examSubmissionRepository = $examSubmissionRepository;
        $this->examRepository = $examRepository;
    }

    /**
     * Get user's submissions for all exams.
     */
    public function index(): JsonResponse
    {
        $userId = Auth::id();
        $submissions = $this->examSubmissionRepository->getSubmissionsByUserId($userId);
        
        return $this->successResponse(
            ExamSubmissionResource::collection($submissions),
            'Exam submissions retrieved successfully'
        );
    }

    /**
     * Get a specific submission.
     */
    public function show(int $id): JsonResponse
    {
        $userId = Auth::id();
        $submission = $this->examSubmissionRepository->findById($id);
        
        if (!$submission) {
            return $this->notFoundResponse('Exam submission not found');
        }
        
        // Ensure user can only access their own submissions
        if ($submission->user_id !== $userId) {
            return $this->forbiddenResponse('You do not have permission to view this submission');
        }
        
        return $this->successResponse(
            new ExamSubmissionResource($submission),
            'Exam submission retrieved successfully'
        );
    }

    /**
     * Submit an exam.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'exam_id' => 'required|integer|exists:exams,id',
            'answers' => 'required|array',
        ]);
        
        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }
        
        $examId = $request->input('exam_id');
        $answers = $request->input('answers');
        $userId = Auth::id();
        
        // Check if the user has already submitted this exam
        $existingSubmissions = $this->examSubmissionRepository->getSubmissionsByUserId($userId);
        $existingSubmission = $existingSubmissions->firstWhere('exam_id', $examId);
        
        if ($existingSubmission) {
            return $this->errorResponse('You have already submitted this exam', 409);
        }
        
        // Get the exam and its questions
        $exam = $this->examRepository->findById($examId);
        
        if (!$exam) {
            return $this->notFoundResponse('Exam not found');
        }
        
        $questions = $this->examRepository->getQuestionsByExamId($examId);
        
        // Calculate the score
        $score = 0;
        $maxScore = $questions->count();
        
        foreach ($questions as $question) {
            $questionId = $question->id;
            
            // Skip if the question wasn't answered
            if (!isset($answers[$questionId])) {
                continue;
            }
            
            $userAnswer = $answers[$questionId];
            
            // Find the correct choice
            $correctChoice = $question->choices->firstWhere('is_correct', 'true');
            
            if ($correctChoice && $userAnswer == $correctChoice->id) {
                $score++;
            }
        }
        
        // Create the submission
        $submissionData = [
            'user_id' => $userId,
            'exam_id' => $examId,
            'score' => $score,
            'max_score' => $maxScore,
            'answers' => $answers,
            'completed_at' => now(),
        ];
        
        $submission = $this->examSubmissionRepository->createSubmission($submissionData);
        
        return $this->successResponse(
            new ExamSubmissionResource($submission),
            'Exam submitted successfully',
            201
        );
    }

    /**
     * Get submissions for a specific exam.
     * (Admin only route)
     */
    public function examSubmissions(int $examId): JsonResponse
    {
        // This would need middleware to ensure only admins can access it
        $exam = $this->examRepository->findById($examId);
        
        if (!$exam) {
            return $this->notFoundResponse('Exam not found');
        }
        
        $submissions = $this->examSubmissionRepository->getSubmissionsByExamId($examId);
        
        return $this->successResponse(
            ExamSubmissionResource::collection($submissions),
            'Exam submissions retrieved successfully'
        );
    }
}
