<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\SubscriptionStatus;
use Carbon\Carbon;

class Subscription extends Model
{
    protected $fillable = ['user_id', 'plan_id', 'price', 'start_date', 'end_date', 'status'];
    protected $casts = [
        'status' => SubscriptionStatus::class,
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // When retrieving a subscription, check if it's expired
        static::retrieved(function (Subscription $subscription) {
            $subscription->checkAndUpdateExpiration();
        });
    }
    
    /**
     * Check if the subscription is expired and update its status if needed.
     * This only updates the model if needed and doesn't save to database
     * to avoid recursion issues.
     */
    public function checkAndUpdateExpiration()
    {
        // Only check active subscriptions that have an end date
        if ($this->status === SubscriptionStatus::ACTIVE && 
            $this->end_date && 
            $this->end_date < Carbon::now()) {
            
            // Update the status without triggering events
            $this->status = SubscriptionStatus::EXPIRED;
            $this->saveQuietly();
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
