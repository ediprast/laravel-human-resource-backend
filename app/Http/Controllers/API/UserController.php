<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // Check email if already registered
            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error('Unauthorized', 401);
            }

            $user = User::where('email', $request->email)->first();

            if (!Hash::check($request->password, $user->password)) {
                throw new Exception('Invalid Password');
            }
            // Generate token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // Return response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Login Success');
        } catch (\Exception $e) {
            return ResponseFormatter::error('Authentication Failed');
        }
    }

    public function register(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => ['required', new Password]
            ]);

            // Create User

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Generate token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // Return response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Register Success');
        } catch (\Exception $e) {
            return ResponseFormatter::error('Register Failed');
        }
    }

    public function logout(Request $request)
    {
        // Revoke token
        $token = $request->user()->currentAccessToken()->delete();

        // Return response
        return ResponseFormatter::success($token, 'Logout Success');
    }

    public function fetch(Request $request)
    {
        $user = $request->user();

        return ResponseFormatter::success($user, 'Fetch Success');
    }
}
