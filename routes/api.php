<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\PersonalAccessToken;

Route::middleware('api')->prefix('api')->group(function() {
    Route::post('tokens/create', function(Request $request) {
        if (! Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Your credentials does not match with our record!',
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $userAlreadyLoggedIn = (bool) PersonalAccessToken::where('tokenable_id', $user->id)
            ->where('tokenable_type', User::class)
            ->count();

        if ($userAlreadyLoggedIn) {
            return response()->json([
                'message' => 'There is already an active session using your account.',
            ]);
        }

        $permissions = $user->getAllPermissions()->pluck('name')->toArray();

        $token = $user->createToken("API TOKEN", $permissions);

        return response()->json([
            'message' => 'User logged in successfully!',
            'token' => $token->plainTextToken,
        ]);
    });
});

