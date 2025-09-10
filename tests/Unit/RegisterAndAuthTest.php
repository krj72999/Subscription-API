<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterAndAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_receive_token()
    {
        $this->withoutExceptionHandling(); // Add this
        $payload = [
            'name' => 'Test',
            'email' => 't@example.com',
            'password' => 'secret',
            'mobile' => '123',
            'address' => 'abc'
        ];

        $this->postJson('/api/users/register', $payload)
            ->assertStatus(201)
            ->assertJsonStructure(['message', 'data' => ['user', 'token']]);
    }
    public function test_user_can_login()
    {
        $user = User::factory()->create(['password' => bcrypt('secret')]);
        $this->postJson('/api/users/login', ['email' => $user->email, 'password' => 'secret'])
            ->assertStatus(200)->assertJsonStructure(['message', 'token', 'user']);
    }
}
