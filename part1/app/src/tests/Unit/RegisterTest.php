<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_can_register_user(): void
    {
        $user = User::factory()->make();
        $response = $this->postJson(route("register"), [
            "name" => $user->name,
            "email" => $user->email,
            "password" => "password",
            "password_confirmation" => "password",
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            "name" => $user->name,
            "email" => $user->email,
        ]);
        $this->assertModelExists($user);
    }
}
