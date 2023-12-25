<?php

namespace VertexIT\Voiler\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class APIAuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        if (! Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Your credentials don\'t match our records!',
            ], 401);
        }

        if (Auth::user()->tokens->count() && ! $request->refresh_token) {
            return response()->json([
                'message' => 'There is already an active session using your account.',
            ], 400);
        }

        if ($request->refresh_token) {
            Auth::user()->tokens()->delete();
        }

        $permissions = Auth::user()->getAllPermissions()->pluck('name')->toArray();

        $token = Auth::user()->createToken("API TOKEN", $permissions);

        return response()->json([
            'message' => 'User logged in successfully!',
            'token' => $token->plainTextToken,
        ]);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'User logged out successfully!',
        ]);
    }

    public function user()
    {
        return Auth::user();
    }
}
