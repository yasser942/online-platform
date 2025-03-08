<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Choice;
class Question extends Model
{
    protected $fillable = ['question_text', 'test_id'];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
}
