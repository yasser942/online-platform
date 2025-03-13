<?php

namespace App\Models;

use App\Models\Exam;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Level extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'thumbnail',
        'course_id',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
