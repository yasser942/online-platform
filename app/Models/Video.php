<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;   
class Video extends Model
{
    protected $fillable = ['name', 'description', 'status', 'lesson_id', 'url'];

    protected $casts = [
        'status' => Status::class,
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
