<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamSubmission extends Model
{
    protected $fillable = [
        'user_id',
        'exam_id',
        'score',
        'max_score',
        'completed_at',
        'answers',
    ];

    protected $casts = [
        'answers' => 'array',
        'completed_at' => 'datetime',
        'score' => 'integer',
        'max_score' => 'integer',
    ];

    /**
     * Get the user that submitted the exam.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the exam that was submitted.
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }
}
