<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['name', 'description', 'status', 'lesson_id', 'url'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
