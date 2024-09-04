<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login'); // Ensure this matches your Blade file's path
    }


    /**
     * Login user and create token
     */
    public function login(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'email' => 'required_without:phone|email',
            'phone' => 'required_without:email|string',
            'password' => 'required|string|min:6',
        ]);
    
        // Return validation errors if any
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        // Retrieve email or phone and password from request
        $credentials = $request->only('email', 'phone', 'password');
    
        // Attempt to find the user by email or phone
        $user = User::where('email', $credentials['email'] ?? null)
                    ->orWhere('phone', $credentials['phone'] ?? null)
                    ->first();
    
        // Check if user exists and password is correct
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        // Check if the request is coming from the API route
        if ($request->is('api/*')) {
            // Create a new personal access token for API authentication
            $token = $user->createToken('Personal Access Token')->plainTextToken;
    
            // Return a JSON response with the access token
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        } else {
            // For web requests, redirect to the dashboard route
            Auth::login($user);
            return redirect()->route('dashboard');
        }
    }
    
 
    /**
     * Logout user (Revoke the token)
     */
    public function logout(Request $request)
    {
        if ($request->is('api/*')) {
            // API request - revoke the token
            $user = $request->user();
    
            try {
                $deleted = $user->tokens()->delete();
    
                // Check if tokens were deleted
                if ($deleted) {
                    return response()->json([
                        'message' => 'Successfully logged out'
                    ]);
                } else {
                    return response()->json([
                        'message' => 'User was already logged out or token is invalid'
                    ], 400);
                }
            } catch (\Exception $e) {
                // Handle any exceptions that occur during token deletion
                return response()->json([
                    'message' => 'An error occurred while logging out',
                    'error' => $e->getMessage()
                ], 500);
            }
        } else {
            // Web request - log out the user and redirect
            // Use Auth facade to log out
            Auth::logout();
    
            // Invalidate the session data
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            return redirect()->route('login')->with('msg', 'You have been logged out.');
        }
    }
    
    


    /**
     * Forgot Password
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required_without:phone|email',
            'phone' => 'required_without:email|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find the user by email or phone
        $user = User::where('email', $request->email ?? null)
            ->orWhere('phone', $request->phone ?? null)
            ->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Initiate password reset
        $status = Password::sendResetLink(
            ['email' => $user->email] // Using email for password reset link
        );
        
        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => __($status)]);
        } else {
            return response()->json(['error' => __($status)], 500);
        }
    }

    /**
     * Reset Password
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? response()->json(['message' => __($status)])
            : response()->json(['error' => __($status)], 500);
    }

    /**
     * Get authenticated user
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
