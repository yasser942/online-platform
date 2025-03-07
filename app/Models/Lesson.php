<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['name', 'description', 'status', 'unit_id'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function pdfs()
    {
        return $this->hasMany(Pdf::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
