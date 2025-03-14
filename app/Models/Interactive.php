<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;
class Interactive extends Model
{
    protected $fillable = [
        'name',
        'description',
        'url',
        'status',
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
