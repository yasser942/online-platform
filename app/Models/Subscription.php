<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\SubscriptionStatus;
class Subscription extends Model
{
    protected $fillable = ['user_id', 'plan_id', 'price', 'start_date', 'end_date', 'status'];
    protected $casts = [
        'status' => SubscriptionStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
