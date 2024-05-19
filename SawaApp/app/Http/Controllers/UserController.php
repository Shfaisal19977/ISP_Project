<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subscription;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        return response()->json([
            'email' => $user->email,
            'password' => $user->password,
        ]);
    }
    public function getUserSubscription(Request $request)
    {
        $userId = $request->user()->id;

        $subscription = Subscription::where('user_id', $userId)->first();

        if ($subscription) {
            return response()->json(['subscription' => $subscription]);
        } else {
            return response()->json(['message' => 'User does not have an active subscription'], 404);
        }
    }
    public function getServiceTypeName($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $subscription = $user->subscriptions()->first();
        if (!$subscription) {
            return response()->json(['error' => 'User has no subscriptions'], 404);
        }
        $serviceType = $subscription->serviceType;
        if (!$serviceType) {
            return response()->json(['error' => 'Service type not found'], 404);
        }
        $serviceTypeName = $serviceType->name;
        return response()->json(['service_type_name' => $serviceTypeName]);
    }
}
