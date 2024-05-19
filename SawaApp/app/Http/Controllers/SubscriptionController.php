<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionChangeSpeedRequest;
use App\Http\Requests\SubscriptionExtendRequest;
use App\Http\Requests\SubscriptionRequest;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function subscribe(SubscriptionRequest $request)
    {
        $request->validated();
        $user = $request->user();
        $subscription = new Subscription([
            'bundle_type' => $request->bundle_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        $user->subscriptions()->save($subscription);
        return response()->json(['message' => 'Subscribed successfully', 'subscription' => $subscription]);
    }
    public function extendSubscription(SubscriptionExtendRequest $request)
    {
        $request->validated();
        $subscription = Subscription::findOrFail($request->subscription_id);
        if ($subscription->current_usage === 0) {
            if ($subscription->end_date->gt(now()->addDays(30))) {
                return response()->json(['message' => 'Subscription was already extended before'], 200);
            }
            $subscription->end_date = $subscription->end_date->addDays(30);
            $subscription->save();
            return response()->json(['message' => 'Subscription extended successfully', 'subscription' => $subscription]);
        } else {
            return response()->json(['message' => 'Subscription cannot be extended as current usage is not 0'], 422);
        }
    }
    public function changeSpeed(SubscriptionChangeSpeedRequest $request)
    {
        $request->validated();
        $subscription = Subscription::findOrFail($request->subscription_id);
        $subscription->speed = $request->speed;
        $subscription->save();

        return response()->json(['message' => 'Speed changed successfully', 'subscription' => $subscription]);
    }
    public function deleteSubscription(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
        ]);

        $subscription = Subscription::findOrFail($request->subscription_id);
        $subscription->delete();
        return response()->json(['message' => 'Subscription deleted successfully']);
    }
    public function getSubscriptionStatus(Request $request)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = $request->user();
            $subscriptionStatus = $user->subscriptions->map(function ($subscription) use ($user) {
                $status = 'active';
                if ($subscription->current_usage > 0 && $subscription->end_date > now()) {
                    $status = 'limited';
                } elseif ($subscription->end_date <= now()) {
                    $status = 'suspended';
                }

                return [
                    'bundle_size' => $subscription->bundle_size,
                    'status' => $status,
                ];
            });
            return response()->json(['subscription_status' => $subscriptionStatus]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve subscription status'], 500);
        }
    }
}
