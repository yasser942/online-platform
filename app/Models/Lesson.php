<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;
class Lesson extends Model
{
    protected $fillable = ['name', 'description', 'status', 'unit_id'];

    protected $casts = [
        'status' => Status::class,
    ];

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

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function interactives()
    {
        return $this->hasMany(Interactive::class);
    }

    
}
