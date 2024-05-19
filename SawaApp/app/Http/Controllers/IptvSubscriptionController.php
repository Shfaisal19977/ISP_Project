<?php

namespace App\Http\Controllers;

use App\Http\Requests\IPTVRequest;
use App\Models\IptvSubscription;

class IptvSubscriptionController extends Controller
{
    public function create(IPTVRequest $request)
    {
        $endDate = date('Y-m-d', strtotime($request->start_date . ' +30 days'));
        $validatedData = $request->validated();
        $subscription = IPTVSubscription::create([
            'user_id' => $request->user_id,
            'package_name' => $request->package_name,
            'start_date' => $request->start_date,
            'end_date' => $endDate,
            'status' => 'active',
        ]);
        return response()->json([
            'message' => 'IPTV subscription created successfully',
            'iptv_subscription' => $subscription
        ], 201);
    }
    public function show($id)
    {
        $iptvSubscription = IptvSubscription::find($id);
        if (!$iptvSubscription) {
            return response()->json(['error' => 'IPTV subscription not found'], 404);
        }
        return response()->json($iptvSubscription);
    }
}
