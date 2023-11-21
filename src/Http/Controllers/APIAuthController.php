<?php

namespace VertexIT\Voiler\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class APIAuthController extends Controller
{
    public function createToken(Request $request): JsonResponse
    {
        if (! Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Your credentials does not match with our record!',
            ], 401);
        }

        if (Auth::user()->tokens->count() && ! $request->refresh_token) {
            return response()->json([
                'message' => 'There is already an active session using your account.',
            ]);
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
}