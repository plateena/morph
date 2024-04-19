<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class LoginApiTest extends TestCase
{
    use RefreshDatabase; // Reset the database after each test

    /**
     * Test the login API endpoint.
     *
     * @return void
     */
    public function test_can_api_login_user(): void
    {
        // Create a user with hashed password
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        // Login request data
        $loginData = [
            'email' => $user->email,
            'password' => 'password',
        ];

        // Send a POST request to the login API endpoint
        $response = $this->postJson(route('api.v1.login'), $loginData);

        // Assert that the API returns a 200 (OK) status code
        $response->assertStatus(200);

        // Assert that the response contains the expected data
        $response->assertJson([
            'success' => true,
            'message' => 'Login successful',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
}
