<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AdminSessionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'token' => 'required|string',
        ]);

        $user = User::findOrFail($request->user_id);
        Auth::login($user, true);

        // Store minimal user data in session
        session([
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'middle_name' => $user->middle_name,
                'last_name' => $user->last_name,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'type' => $user->user_type,
                'status' => $user->is_active,
            ],
            'api_token' => $request->token,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Session stored successfully',
        ]);

    }   
}