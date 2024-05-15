<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PasswordController extends Controller
{
    public function resetPassword(ResetPasswordRequest $request)
    {
        $nationalId = $request->national_id;
        $password = $request->password;
        $passwordConfirmation = $request->password_confirmation;
        $user = User::where('national_id', $nationalId)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $user->update([
            'password' => Hash::make($password)
        ]);
        $user->tokens()->delete();
        return response()->json(['message' => 'Password reset successfully'], 200);
    }
}
