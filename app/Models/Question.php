<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Choice;
class Question extends Model
{
    protected $fillable = ['question_text', 'exam_id'];

    public function questionable()
    {
        return $this->morphTo();
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }

    
}
