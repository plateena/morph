<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;
use App\Models\User;

class RegisterApiTest extends TestCase
{
    use RefreshDatabase; // Reset the database after each test

    /**
     * Test the register API endpoint.
     *
     * @return void
     */
    public function test_can_api_register_user(): void
    {
        // Create user data using the User factory
        $userData = User::factory()->make()->toArray();

        // Add password and password_confirmation to the user data
        $userData["password"] = "password";
        $userData["password_confirmation"] = "password";

        // Send a POST request to the register API endpoint
        $response = $this->postJson(route("api.v1.register"), $userData);

        // Assert that the API returns a 201 (Created) status code
        $response->assertStatus(201);

        // Assert that the response contains the user data without password and password_confirmation
        $response->assertJson([
            "success" => true,
            "message" => "User registered successfully",
            "user" => collect($userData)
                ->except([
                    "password",
                    "password_confirmation",
                    "email_verified_at",
                ])
                ->toArray(),
        ]);

        // Assert that the user is created in the database
        $this->assertDatabaseHas("users", [
            "email" => $userData["email"],
        ]);
    }
}
