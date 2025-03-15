<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;
use App\Enums\SubscriptionStatus;

class CheckSubscriptionExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire subscriptions where end_date has passed';

    /**
     * Execute the console command.
     */
    public function handle()
{
    // Expire subscriptions where end_date has passed
    Subscription::query()
        ->whereIn('status', [
            SubscriptionStatus::ACTIVE->value,
            SubscriptionStatus::CANCELED->value
        ])
        ->where('end_date', '<', now())
        ->update(['status' => SubscriptionStatus::EXPIRED->value]);

    $this->info('Expired subscriptions updated.');
}
}
