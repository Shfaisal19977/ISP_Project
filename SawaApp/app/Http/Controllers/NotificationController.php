<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications(Request $request)
    {
        $user = $request->user();
        $notifications = $user->notifications()->get(['data']);
        return response()->json($notifications);
    }
}
