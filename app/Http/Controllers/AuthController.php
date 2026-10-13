<?php

namespace App\Http\Controllers;

use App\Models\OtpVerification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show login form (Blade).
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('profile');
        }
        return view('pages.auth.login');
    }

    /**
     * Send OTP to the provided email.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = strtolower(trim($request->email));

        // Generate 6-digit OTP
        $otp = (string) rand(100000, 999999);

        // Store OTP with 10-minute expiry
        OtpVerification::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
            'is_used' => false,
        ]);

        $message = "Your verification OTP is: {$otp} (Valid for 10 minutes)";

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent successfully to ' . $email,
                'demo_otp' => $otp, // provided for testing convenience
            ]);
        }

        return redirect()->route('login.verify.view', ['email' => $email])
            ->with('status', 'OTP generated: ' . $otp)
            ->with('demo_otp', $otp);
    }

    /**
     * Show OTP verification form (Blade).
     */
    public function showVerifyOtp(Request $request)
    {
        $email = $request->query('email');
        if (!$email) {
            return redirect()->route('login');
        }

        return view('pages.auth.verify', compact('email'));
    }

    /**
     * Verify OTP and log user in.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string',
        ]);

        $email = strtolower(trim($request->email));
        $otp = trim($request->otp);

        $record = OtpVerification::where('email', $email)
            ->where('otp', $otp)
            ->where('is_used', false)
            ->where('expires_at', '>=', Carbon::now())
            ->latest()
            ->first();

        if (!$record) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid or expired OTP code.',
                ], 422);
            }

            return back()->withErrors(['otp' => 'Invalid or expired OTP code.'])->withInput();
        }

        // Mark OTP as used
        $record->update(['is_used' => true]);

        // Find or create user
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => explode('@', $email)[0],
                'password' => Hash::make(Str::random(16)),
            ]
        );

        // Web session login
        Auth::login($user, true);

        // Create Sanctum API Token
        $token = $user->createToken('auth-token')->plainTextToken;

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Logged in successfully.',
                'token' => $token,
                'user' => $user,
            ]);
        }

        return redirect()->intended(route('profile'))->with('status', 'Welcome back, ' . ($user->name ?? $user->email));
    }

    /**
     * Show user profile.
     */
    public function profile(Request $request)
    {
        $user = Auth::user() ?? $request->user();

        if (!$user) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        $ordersCount = $user->orders()->count();
        $wishlistsCount = $user->wishlists()->count();
        $cartCount = $user->cartItems()->count();

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'user' => $user,
                'stats' => [
                    'orders_count' => $ordersCount,
                    'wishlists_count' => $wishlistsCount,
                    'cart_count' => $cartCount,
                ],
            ]);
        }

        return view('pages.profile', compact('user', 'ordersCount', 'wishlistsCount', 'cartCount'));
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user() ?? $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
        ]);

        $user->update($validated);

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully.',
                'user' => $user,
            ]);
        }

        return back()->with('status', 'Profile updated successfully!');
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        $user = Auth::user() ?? $request->user();

        if ($user && method_exists($user, 'currentAccessToken') && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Logged out successfully.',
            ]);
        }

        return redirect()->route('home')->with('status', 'Logged out successfully.');
    }
}
