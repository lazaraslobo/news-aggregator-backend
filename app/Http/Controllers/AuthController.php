<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPreference;
use App\Responses\UserResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
            ]);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function register(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Make sure to include the `password_confirmation` field in your request
        ]);

        // Create the new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate a new Sanctum token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return the created user and token
        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        // Revoke the token of the currently authenticated user
        $user = Auth::user();

        // Optionally, you can revoke all tokens for this user
        $user->tokens()->delete();

        // If you're using Laravel session to store user data
        $request->session()->invalidate();

        // Regenerate the session token to prevent session fixation attacks
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function updateUserPreferences(Request $request){
        $user = Auth::user();

        $request->validate([
            'key' => 'required|string',
            'value' => 'required',
        ]);

        (new UserPreference())::updateOrInsertPreference(
            $user->id,
            $request->key,
            $request->value
        );

        return response()->json([
            "user" => new UserResponse(Auth::user()),
            'message' => 'Preferences updated successfully'
        ]);
    }
}
