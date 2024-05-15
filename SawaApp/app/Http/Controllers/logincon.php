<?php

namespace App\Http\Controllers;

use App\Http\Requests\login_request;
use App\Http\Requests\LoginRequest; // Create a LoginRequest class for validation
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Required for Laravel authentication
use Laravel\Sanctum\HasApiTokens;

class logincon extends Controller
{
    public function initiateLogin(login_request $request) // Endpoint for initial phone number
    {
        $phoneNumber = $request->input('phone_number');

        $user = User::where('phone_number', $phoneNumber)->first();

        if (!$user) {
            return response()->json(['message' => 'Phone number not found'], 404);
        }

        $verificationCode = $user->generateVerificationCode($phoneNumber);

        // **Security:** Don't return the verification code

        return response()->json([
            'message' => 'Verification code sent to your phone',
            'user_id' => $user->id,
        ], 200);
    }

    public function verifyLogin(Request $request)
    {
        $userId = $request->input('id');
        $verificationCode = $request->input('verification_code');

        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'Invalid user ID'], 401);
        }

        if ($verificationCode !== $user->verification_code) {
            return response()->json(['message' => 'Invalid verification code'], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ], 200);
    }
    public function logout(Request $request)
    {
        return User::logout($request->user());
    }
}
