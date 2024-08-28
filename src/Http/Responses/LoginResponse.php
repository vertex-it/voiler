<?php

namespace VertexIT\Voiler\Http\Responses;

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

    private function getUserResourceIfExists($user): \App\Http\Resources\UserResource | array
    {
        if (class_exists('\App\Http\Resources\UserResource')) {
            $userResource = new \App\Http\Resources\UserResource($user);
        }

        return $userResource ?? $user->toArray();
    }
}