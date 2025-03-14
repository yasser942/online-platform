<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Enums\Status;
class Test extends Model
{
    protected $fillable = ['name', 'description', 'status', 'lesson_id'];

    protected $casts = [
        'status' => Status::class,
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function questions()
    {
        return $this->morphMany(Question::class, 'questionable');
    }
}
