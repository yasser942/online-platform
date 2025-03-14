<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;
class Plan extends Model
{
    protected $fillable = ['name', 'description', 'price', 'duration', 'status'];

    protected $casts = [
        'status' => Status::class,
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
