<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;
class Unit extends Model
{
    protected $fillable = ['name', 'description', 'status', 'level_id'];

    protected $casts = [
        'status' => Status::class,
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    
}
