<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Channel;

class ChannelController extends Controller
{
    public function getChannelsByCategory(Request $request, $category)
    {
        $user = $request->user();
        $channels = Channel::whereHas('iptvSubscription', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('category', $category)->get();
        return response()->json($channels);
    }
}
