<?php

namespace VertexIT\Voiler\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use VertexIT\Voiler\Http\Requests\LoginAPIRequest;
use VertexIT\Voiler\Http\Requests\RegisterAPIRequest;

class APIAuthController extends Controller
{
    public function login(LoginAPIRequest $request): JsonResponse
    {
        $credentials = $request->only([
            $request->email ? 'email' : 'username',
            'password',
        ]);

        if (! Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Your credentials don\'t match our records!',
            ], 401);
        }

        if ($request->refresh_token) {
            Auth::user()->tokens()->delete();
        }

        $permissions = Auth::user()->getAllPermissions()->pluck('name')->toArray();

        $token = Auth::user()->createToken("API TOKEN", $permissions);

        return response()->json([
            'message' => 'User logged in successfully!',
            'token' => $token->plainTextToken,
            'user' => $this->getUserResourceIfExists(Auth::user()),
        ]);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'User logged out successfully!',
        ]);
    }

    public function register(RegisterAPIRequest $request)
    {
        $input = $request->validated();

        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        $permissions = $user->getAllPermissions()->pluck('name')->toArray();

        $token = $user->createToken("API TOKEN", $permissions);

        return response()->json([
            'message' => 'User registered successfully!',
            'token' => $token->plainTextToken,
            'user' => $this->getUserResourceIfExists($user),
        ]);
    }

    public function user()
    {
        return $this->getUserResourceIfExists(Auth::user());
    }

    private function getUserResourceIfExists(User $user): \App\Http\Resources\UserResource | array
    {
        if (class_exists('\App\Http\Resources\UserResource')) {
            $userResource = new \App\Http\Resources\UserResource($user);
        }

        return $userResource ?? $user->toArray();
    }
}
