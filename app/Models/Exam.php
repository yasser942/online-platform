<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'level_id',
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

        public function questions()
        {
            return $this->morphMany(Question::class, 'questionable');
        }
}
