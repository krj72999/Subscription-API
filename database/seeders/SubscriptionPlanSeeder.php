<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            ['key' => 'basic', 'name' => 'Basic', 'requests_per_minute' => 3, 'description' => 'Basic plan: 3 req/min'],
            ['key' => 'standard', 'name' => 'Standard', 'requests_per_minute' => 5, 'description' => 'Standard plan: 5 req/min'],
            ['key' => 'premium', 'name' => 'Premium', 'requests_per_minute' => 10, 'description' => 'Premium plan: 10 req/min'],
        ];
        foreach ($plans as $p) {
            SubscriptionPlan::updateOrCreate(['key' => $p['key']], $p);
        }
    }
}
