<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;


class CheckSubscriptionAndRateLimit
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Get active subscription
        $subscription = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$subscription) {
            return response()->json(['message' => 'You need an active subscription to access this API.'], 403);
        }

        $planKey = $subscription->plan->key ?? 'basic';
        $limits = [
            'basic' => 3,
            'standard' => 5,
            'premium' => 10,
        ];
        $limit = $limits[$planKey] ?? 3;

        $key = 'rate_limit:' . $user->id;
        $count = Cache::get($key, 0);

        if ($count >= $limit) {
            return response()->json(['message' => 'API rate limit exceeded.'], 429);
        }

        if ($count === 0) {
            Cache::put($key, 1, 60);
        } else {
            Cache::increment($key);
        }

        return $next($request);
    }
}
