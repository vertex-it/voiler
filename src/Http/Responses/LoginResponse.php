<?php

namespace VertexIT\Voiler\Http\Responses;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Fortify;

class LoginResponse implements \Laravel\Fortify\Contracts\LoginResponse
{
    public function toResponse($request)
    {
        return $request->wantsJson()
            ? $this->getUserResourceIfExists(Auth::user())
            : redirect()->intended(Fortify::redirects('login'));
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