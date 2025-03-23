<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Enums\SubscriptionStatus;
use Symfony\Component\HttpFoundation\Response;

class CheckActiveSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // Get user's active subscription
        $activeSubscription = $request->user()->subscriptions()
            ->where('status', SubscriptionStatus::ACTIVE)
            ->where('end_date', '>=', now())
            ->whereNot('status', SubscriptionStatus::CANCELED)
            ->first();

        if (!$activeSubscription) {
            return response()->json([
                'message' => 'Your subscription has expired or been canceled. Please renew your subscription to access this content.',
                'subscription_required' => true
            ], 403);
        }

        return $next($request);
    }
}
