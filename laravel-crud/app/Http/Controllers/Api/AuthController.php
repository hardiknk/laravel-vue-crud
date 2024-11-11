<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create($request->validated());
            return response()->json([
                'status' => 'success',
                'data' => $user,
                'message' => 'User created successfully'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'User creation failed'
            ], 500);
        }
    }
    public function login(LoginRequest $request)
    {
        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = auth()->user();
        // $token = $user->createToken('authToken')->plainTextToken;
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'token' => $token
            ],
            'message' => 'Login successful'
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Logout successful'
        ], 200);
    }

    public function show()
    {
        return response()->json([
            'status' => 'success',
            'data' => auth()->user(),
            'message' => 'User retrieved successfully'
        ], 200);
    }
}
