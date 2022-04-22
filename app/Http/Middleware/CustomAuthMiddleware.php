<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($token = $request->bearerToken()) {
            $user = User::where('token', $token)->first();
            if ($user) {
                Auth::login($user);
                return $next($request);
            }
        }
        return response()->json([
            'type' => 'Error',
            'message' => 'Token auth error'
        ], 401);
    }
}
