<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function showRegister()
    {
        return view('admin.auth.register');
    }
    
    public function showForgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    public function dashboard()
    {   
        return view('admin.dashboards.dashboard');
    }

    public function superAdminDashboard()
    {   
        return view('sadmin.dashboard.super-admin');
    }

    public function logout(Request $request)
    {
        try {
            if ($request->bearerToken()) {
                JWTAuth::invalidate(JWTAuth::getToken());
            }
        } catch (\Exception $e) {
            // Token expired or already invalid
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Logged out successfully'
            ]);
        }

        return redirect()->route('login');
    }
}