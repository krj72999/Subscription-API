<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $data = $request->validate(['plan_key' => 'required|string|in:basic,standard,premium']);
        $user = $request->user();
        $plan = SubscriptionPlan::where('key', $data['plan_key'])->firstOrFail();

        $sub = Subscription::updateOrCreate(
            ['user_id' => $user->id],
            ['plan_id' => $plan->id, 'status' => 'active', 'started_at' => Carbon::now(), 'cancelled_at' => null]
        );

        return response()->json(['message' => 'Subscribed successfully', 'subscription' => $sub]);
    }

    public function status(Request $request)
    {
        $sub = $request->user()->subscription;
        if (!$sub) {
            return response()->json(['message' => 'No active subscription', 'data' => null]);
        }
        return response()->json(['data' => [
            'plan' => $sub->plan->name,
            'key' => $sub->plan->key,
            'status' => $sub->status,
            'started_at' => $sub->started_at,
            'cancelled_at' => $sub->cancelled_at
        ]]);
    }

    public function cancel(Request $request)
    {
        $sub = $request->user()->subscription;
        if (!$sub || $sub->status !== 'active') {
            return response()->json(['message' => 'No active subscription to cancel.'], 400);
        }
        $sub->update(['status' => 'cancelled', 'cancelled_at' => Carbon::now()]);
        return response()->json(['message' => 'Subscription cancelled successfully']);
    }
}
