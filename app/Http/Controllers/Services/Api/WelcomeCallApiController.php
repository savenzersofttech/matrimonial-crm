<?php

namespace App\Http\Controllers\Services\Api;

use App\Http\Controllers\Controller;
use App\Models\WelcomeCall;
use App\Models\Profile;

class WelcomeCallApiController extends Controller
{
    public function show(Profile $profile)
    {
        $welcomeCall = WelcomeCall::with(['profile', 'followUpHistories.employee'])
            ->where('profile_id', $profile->id)
            ->first();

        if (!$welcomeCall) {
            return response()->json([
                'success' => false,
                'message' => 'Welcome Call not found for this profile.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $welcomeCall,
        ]);
    }
}
