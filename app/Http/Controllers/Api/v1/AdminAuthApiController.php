<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AdminAuthApiController extends BaseController
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name'   => 'required|string|max:255',
            'middle_name'  => 'nullable|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'mobile'       => 'required|string',
            'password'     => 'required|string|min:6|confirmed',
        ]);

        // Generate unique user code
        $userCode = 'USR-' . strtoupper(uniqid());

        // Create user
        $user = User::create([
            'user_code'       => $userCode,
            'first_name'      => $validated['first_name'],
            'middle_name'     => $validated['middle_name'],
            'last_name'       => $validated['last_name'],
            'full_name'       => trim(
                $validated['first_name'] . ' ' .
                ($validated['middle_name'] ?? '') . ' ' .
                $validated['last_name']
            ),
            'email'           => $validated['email'],
            'mobile'          => $validated['mobile'],
            'password'        => Hash::make($validated['password']),
            'user_type'       => 'admin',
            'is_active'       => 1,
            'email_verified'  => 1,
            'mobile_verified' => 1,
        ]);

        /* -------------------------------------------------
        ✅ AUTO LOGIN + JWT + SESSION
        ------------------------------------------------- */

        // 1️⃣ Generate JWT token
        $token = JWTAuth::fromUser($user);

        // 2️⃣ Login user using web guard (session-based)
        Auth::login($user, true);

        // 3️⃣ Store minimal data in session
        session([
            'auth_user' => [
                'id'    => $user->id,
                'name'  => $user->full_name,
                'email' => $user->email,
                'type'  => $user->user_type,
            ],
            'jwt_token' => $token,
        ]);

        return $this->sendResponse([
            'user' => [
                'id'    => $user->id,
                'name'  => $user->full_name,
                'email' => $user->email,
                'type'  => $user->user_type,
            ],
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60,
        ], 'User registered & logged in successfully', 201);
    }

    /**
     * Login user and return JWT token
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check if user exists and password is correct
        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return $this->sendError('User not found', 401);
        }

        if (!Hash::check($validated['password'], $user->password)) {
            \Log::error('Password mismatch for user: ' . $validated['email']);
            \Log::error('Provided password hash attempt failed');
            return $this->sendError('Invalid email or password', 401);
        }

        // Check if user is active
        if (!$user->is_active) {
            return $this->sendError('Your account has been deactivated', 403);
        }

        // Generate JWT token
        $token = JWTAuth::fromUser($user);

        return $this->sendResponse([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ], 'Login successful', 200);
    }

    /**
     * Get authenticated user
     */
    public function me(Request $request)
    {
        $user = auth('api')->user();

        return $this->sendResponse([
            'user' => $user,
        ], 'User fetched successfully');
    }

    /**
     * Logout user (token invalidation)
     * This endpoint doesn't require authentication (401 errors are handled gracefully)
     */
    public function logout(Request $request)
    {
        try {
            // Try to invalidate JWT token if present
            if ($request->bearerToken()) {
                JWTAuth::invalidate(JWTAuth::getToken());
            }
        } catch (\Exception $e) {
            // Token may already be expired or invalid - that's ok
            \Log::debug('Token invalidation: ' . $e->getMessage());
        }

        // Logout from web session
        Auth::logout();

        return $this->sendResponse([], 'Logged out successfully', 200);
    }

    /**
     * Logout user session (clear session data)
     * This endpoint doesn't require authentication
     */
    public function logoutSession(Request $request)
    {
        try {
            // Invalidate session
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } catch (\Exception $e) {
            \Log::debug('Session invalidation: ' . $e->getMessage());
        }

        return $this->sendResponse([], 'Session cleared successfully', 200);
    }
    public function refresh(Request $request)
    {
        try {
            $token = auth('api')->refresh();

            return $this->sendResponse([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
            ], 'Token refreshed successfully');
        } catch (\Exception $e) {
            return $this->sendError('Could not refresh token', 401);
        }
    }
}
