<?php

namespace Tests\Feature;


use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;

class RateLimitTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_rate_limit_based_on_plan()
    {
        // create plan
        $plan = SubscriptionPlan::create([
            'key' => 'basic',
            'name' => 'Basic',
            'requests_per_minute' => 3
        ]);

        // create user
        $user = User::factory()->create();

        // attach subscription with plan relation
        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => 'active',
            'started_at' => now(),
        ]);
        $token = $user->createToken('test')->plainTextToken;
        for ($i = 0; $i < 3; $i++) {
            $this->withHeader('Authorization', 'Bearer ' . $token)
                ->getJson('/api/users/' . $user->id)
                ->assertStatus(200);
        }
        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/users/' . $user->id)
            ->assertStatus(429);
    }
}
