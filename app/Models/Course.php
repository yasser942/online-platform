<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'thumbnail'
        ];

        public function levels()
        {
            return $this->hasMany(Level::class);
        }
}
