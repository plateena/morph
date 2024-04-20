<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse
    {
        // Validate the incoming request data
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users",
            "password" => "required|string|min:8|confirmed",
        ]);

        // Create and save the new user
        $user = User::create([
            "name" => $request->input("name"),
            "email" => $request->input("email"),
            "password" => Hash::make($request->input("password")),
        ]);

        // Return a JSON response with a success message and the new user data
        return response()->json(
            [
                "success" => true,
                "message" => "User registered successfully",
                "user" => new UserResource($user),
            ],
            201
        ); // 201 Created status code
    }

    /**
     * Authenticate a user with the provided credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        // Validate the incoming request data
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        // Attempt to retrieve the user based on the provided email
        $user = User::where("email", $request->email)->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            // Authentication failed, return an error response
            return response()->json(
                [
                    "success" => false,
                    "message" => "Invalid email or password.",
                ],
                401
            );
        }

        // Generate a token for the authenticated user
        $token = $user->createToken($request->device_name)->plainTextToken;

        // Authentication successful, return success response with token
        return response()->json(
            [
                "success" => true,
                "message" => "Login successful.",
                "data" => [
                    "token" => $token,
                ],
            ],
            200
        );
    }

}
