<?php

namespace VertexIT\Voiler\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
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

    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'User logged out successfully!',
        ]);
    }

    public function register(): JsonResponse
    {
        $requestClass = \App\Http\Requests\RegisterAPIRequest::class;
        $requestClass = ! class_exists($requestClass)
            ? RegisterAPIRequest::class
            : $requestClass;

        $request = app($requestClass);

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

    public function user(): array | JsonResource
    {
        return $this->getUserResourceIfExists(Auth::user());
    }

    private function getUserResourceIfExists(User $user): array | JsonResource
    {
        $userResourceFQN = \App\Http\Resources\UserResource::class;

        if (class_exists($userResourceFQN)) {
            return new $userResourceFQN($user);
        }

        return $user->toArray();
    }
}
