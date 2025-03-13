<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;
class Course extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'thumbnail'
        ];

    protected $casts = [
        'status' => Status::class,
    ];

        public function levels()
        {
            return $this->hasMany(Level::class);
        }
}
